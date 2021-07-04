<?php

return [
	'settings'	=> [
		'addContentLengthHeader'	=> false,
		'determineRouteBeforeAppMiddleware'	=> false,
		'displayErrorDetails'		=> true,
		'db' => [
			'driver' 	=> getenv("DB_CONNECTION"),
			'host' 		=> getenv("DB_HOST"),
			'username' 	=> getenv("DB_USERNAME"),
			'password' 	=> getenv("DB_PASSWORD"),
			'database' 	=> getenv("DB_DATABASE"),
			'port' 		=> getenv("DB_PORT"),
			'charset' 	=> getenv("DB_CHARSET"),
			'collation' => getenv("DB_COLLATE"),
			'prefix' 	=> getenv("DB_PREFIX"),
			'options' 	=> [
				// Turn off persistent connections
				PDO::ATTR_PERSISTENT => false,
				// Enable exceptions
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				// Emulate prepared statements
				PDO::ATTR_EMULATE_PREPARES => true,
				// Set default fetch mode to array
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				// Set character set
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' .getenv("DB_CHARSET"). ' COLLATE ' .getenv("DB_COLLATE")
			],
		],
		'twig' => [ // Template paths
			'paths' => [
				realpath(__DIR__ . '/..') . '/resources/views',
			],
			// Twig environment options
			'options' => [
				// Should be set to true in production
				'cache_enabled' => false,
				'cache_path' => realpath(__DIR__ . '/..') . '/tmp/twig',
			],
		]
	]
];
