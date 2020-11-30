<?php
return [
   'db' => [
		'driver' => 'mysql',
     	'host' 	=>'localhost',
     	'username' => 'root',
     	'password' => '',
		'database' => 'test',
		'port' => '3306',
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => '',
		'options' => [
			// Turn off persistent connections
			PDO::ATTR_PERSISTENT => false,
			// Enable exceptions
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			// Emulate prepared statements
			PDO::ATTR_EMULATE_PREPARES => true,
			// Set default fetch mode to array
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			// Set character set
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
		],
  	]
];