<?php
$container = $app->getContainer();

/** =============== Set database connection =============== */
$container['db'] = function ($c) {
    try {
        $db = $c['settings']['db'];

        return new PDO($db['driver']. ":host=" .$db['host']. ";dbname=" .$db['database'], $db['username'], $db['password'], $db['options']);
    }
    catch(\Exception $ex) {
        return $ex->getMessage();
    }   
};

/** =============== Register Controllers =============== */
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

/** =============== Register Controllers =============== */
$container['HomeController'] = function ($c) {
    return new \App\Controllers\HomeController($c);
};

$container['UserController'] = function ($c) {
    return new \App\Controllers\UserController($c);
};

$container['PatientController'] = function ($c) {
    return new \App\Controllers\PatientController($c);
};
