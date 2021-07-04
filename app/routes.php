<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

/** =============== CORS =============== */
$app->options('./{routes:.+}', function ($req, $res) {
    return $res;
});

$app->add(function ($req, $res, $next) {
    if ($req->getMethod() !== 'OPTIONS') {
        $response = $next($req, $res);

        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }

    $res = $res->withHeader('Access-Control-Allow-Origin', '*');
    $res = $res->withHeader('Access-Control-Allow-Methods', $req->getHeaderLine('Access-Control-Request-Method'));
    $res = $res->withHeader('Access-Control-Allow-Headers', $req->getHeaderLine('Access-Control-Request-Headers'));

    return $next($req, $res);
});

/** =============== ROUTES =============== */
$app->get('/', 'HomeController:home')->setName('home');

$app->group('', function() {
    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');

    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function() {
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    
    $this->get('/patients', 'PatientController:getAll')->setName('patients');
    $this->get('/patients/{cid}', 'PatientController:getByCid')->setName('patient');
    
    $this->get('/users', 'UserController:index')->setName('users');
    $this->get('/users/{cid}', 'UserController:user')->setName('user');
})->add(new AuthMiddleware($container));

/** use this route if page not found. */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/routes:.+', function ($req, $res) {
    $handler = $this->notFoundHandler; //using default slim page not found handler.
    return $handler($req, $res);
});
/** =============== ROUTES =============== */