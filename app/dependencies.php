<?php

$container = $app->getContainer();

/** 
 * ============================================================
 * Inject data model with using Eloquent
 * ============================================================
 */
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

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

/** ===================== Using Eloquent ===================== */
$container['db'] = function($c) use ($capsule) {
    return $capsule;
};



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

$container['PatientController'] = function ($c) {
    return new App\Controllers\PatientController($c);
};

/** 
 * ============================================================
 * Inject Middleware
 * ============================================================
 */
$container['csrf'] = function($c) {
    return new \Slim\Csrf\Guard;
};

$app->add(new App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new App\Middleware\OldInputMiddleware($container));
$app->add(new App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);
