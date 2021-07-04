<?php

// use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

/** 
 * ============================================================
 * App Configuration
 * ============================================================
 */

$config = require __DIR__ . '/../config/app.php';
/** Create object of slim/app with settings */
$app = new Slim\App($config);

/** 
 * ============================================================
 * Dependencies Injection
 * ============================================================
 */

require __DIR__ . '/../app/dependencies.php';

// v::with('App\\Validation\\Rules\\');

/** 
 * ============================================================
 * ROUTES
 * ============================================================
 */

require __DIR__ . '/../app/routes.php';
