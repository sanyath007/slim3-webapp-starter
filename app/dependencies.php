<?php

$container = $app->getContainer();

/** 
 * ============================================================
 * Use data model with Eloquent
 * ============================================================
 */
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/** 
 * ============================================================
 * Set database connection 
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
 * Set main view with twig template engine
 * ============================================================
 */
$container['view'] = function ($c) {
    $template_path = $c['settings']['twig']['paths'];
    $cache_path = $c['settings']['twig']['options']['cache_path'];

    $view = new \Slim\Views\Twig($template_path, [
        'cache' => false
    ]);

    $router = $c->get('router');
    
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $router,
        $uri
    ));

    return $view;
};

/** 
 * ============================================================
 * Register Controllers
 * ============================================================
 */
$container['HomeController'] = function ($c) {
    return new \App\Controllers\HomeController($c);
};

$container['UserController'] = function ($c) {
    return new \App\Controllers\UserController($c);
};

$container['PatientController'] = function ($c) {
    return new \App\Controllers\PatientController($c);
};
