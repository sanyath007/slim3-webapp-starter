<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

/** Configuration */
$settings = require __DIR__ . '/../config/settings.php';
$db = require __DIR__ . '/../config/db.php';
$config['settings'] = array_merge($settings, $db);

/** Create object of slim/app with settings */
$app = new Slim\App($config);

/** Handle Dependencies */
require __DIR__ . '/../app/dependencies.php';

/** ROUTES */
require __DIR__ . '/../app/routes.php';
