<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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
$app->get('/', 'HomeController:home');

$app->get('/patients', 'PatientController:getAll');
$app->get('/patients/{cid}', 'PatientController:getByCid');

$app->get('/user/{cid}', 'UserController:user');

/** use this route if page not found. */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/routes:.+', function ($req, $res) {
    $handler = $this->notFoundHandler; //using default slim page not found handler.
    return $handler($req, $res);
});
/** =============== ROUTES =============== */