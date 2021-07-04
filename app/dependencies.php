<?php

use Tuupola\Middleware\HttpBasicAuthentication;

$container = $app->getContainer();

/** 
 * ============================================================
 * Inject error handler
 * ============================================================
 */

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $response
                ->withStatus(500)
                ->withHeader("Content-Type", "application/json")
                ->write($exception->getMessage());
    };
};

/** 
 * ============================================================
 * Inject data model with using Eloquent
 * ============================================================
 */

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/** ===================== Using Eloquent ===================== */
$container['db'] = function($c) use ($capsule) {
    return $capsule;
};

/** 
 * ============================================================
 * Inject database connection 
 * ============================================================
 */

/** ===================== Using PDO ===================== */
// $container['db'] = function ($c) {
//     try {
//         $conStr = $c['settings']['db'];

//         return new PDO($conStr['driver']. ":host=" .$conStr['host']. ";dbname=" .$conStr['database'], $conStr['username'], $conStr['password'], $conStr['options']);
//     }
//     catch(\Exception $ex) {
//         return $ex->getMessage();
//     }   
// };

/** 
 * ============================================================
 * Inject Auth class
 * ============================================================
 */
$container['auth'] = function($c) {
    return new App\Auth\Auth;
};

/** 
 * ============================================================
 * Inject view with using twig template engine
 * ============================================================
 */
$container['view'] = function ($c) {
    $template_path = $c['settings']['twig']['paths'];
    $cache_path = $c['settings']['twig']['options']['cache_path'];

    $view = new Slim\Views\Twig($template_path, [
        'cache' => false
    ]);

    $router = $c->get('router');
    
    $uri = \Slim\Http\Uri::createFromEnvironment(new Slim\Http\Environment($_SERVER));
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $router,
        $uri
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $c->auth->check(),
        'user' => $c->auth->user(),
    ]);

    return $view;
};

/** 
 * ============================================================
 * Inject Validator
 * ============================================================
 */
$container['validator'] = function($c) {
    return new App\Validation\validator;
};

/** 
 * ============================================================
 * Inject Logger
 * ============================================================
 */
$container['logger'] = function($c) {
    $logger = new Monolog\Logger('My_logger');
    $file_handler = new Monolog\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);

    return $logger;
};

/** 
 * ============================================================
 * Inject CSRF Guard
 * ============================================================
 */
$container['csrf'] = function($c) {
    return new \Slim\Csrf\Guard;
};

/** 
 * ============================================================
 * Inject JWT
 * ============================================================
 */
$container['jwt'] = function($c) {
    return new StdClass;
};

/** 
 * ============================================================
 * Inject Controllers
 * ============================================================
 */
$container['HomeController'] = function ($c) {
    return new App\Controllers\HomeController($c);
};

$container['AuthController'] = function ($c) {
    return new App\Controllers\Auth\AuthController($c);
};

$container['UserController'] = function ($c) {
    return new App\Controllers\UserController($c);
};

/** 
 * ============================================================
 * Guard middleware
 * ============================================================
 */
$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);

/** 
 * ============================================================
 * JWT middleware
 * ============================================================
 */
// $app->add(new Slim\Middleware\JwtAuthentication([
//     "path"          => '/api',
//     "logger"        => $container['logger'],
//     "passthrough"   => ["/test"],
//     "secret"        => getenv("JWT_SECRET"),
//     "callback"      => function($req, $res, $args) use ($container) {
//         $container['jwt'] = $args['decoded'];
//     },
//     "error"         => function($req, $res, $args) {
//         $data["status"] = "0";
//         $data["message"] = $args["message"];
//         $data["data"] = "";
        
//         return $res
//                 ->withHeader("Content-Type", "application/json")
//                 ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
//     }
// ]));

/** 
 * ============================================================
 * CORS middleware
 * ============================================================
 */
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);

    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
