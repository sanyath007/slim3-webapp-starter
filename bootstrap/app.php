<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

/** 
 * ============================================================
 * App Configuration
 * ============================================================
 */
$settings = require __DIR__ . '/../config/settings.php';
$db = require __DIR__ . '/../config/db.php';
$config['settings'] = array_merge($settings, $db);
/** Create object of slim/app with settings */
$app = new Slim\App($config);

/** 
 * ============================================================
 * Dependencies Injection
 * ============================================================
 */
require __DIR__ . '/../app/dependencies.php';

v::with('App\\Validation\\Rules\\');

/** 
 * ============================================================
 * ROUTES
 * ============================================================
 */
require __DIR__ . '/../app/routes.php';
