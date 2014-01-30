<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
	'db' => array(
		'driver' => 'Pdo',
		'dsn' => 'mysql:dbname=guestbook_demo;host=localhost',
		'driver_options' => array(
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
		'username' => 'root',
		'password' => 'password'
	),
	'oauth2' => array(
		'auth' => array(
			"auth_uri" => "https://accounts.google.com/o/oauth2/auth",
			"token_uri" => "https://accounts.google.com/o/oauth2/token",
			'scopes' => array(
				'https://www.googleapis.com/auth/userinfo.profile'	
			)
		)	
	)
);
