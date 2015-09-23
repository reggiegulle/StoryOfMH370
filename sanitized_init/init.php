<?php
	session_start();

	//Define core paths
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	
	defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'XAMPP' . DS . 'htdocs' . DS . 'mh370');
	
	//store necessary values in the GLOBAL session
	$GLOBALS['config'] = [
		'mysql' => [
			'host' => 'xxx',
			'username' => 'xxx',
			'password' => 'xxx',
			'db' => 'xxx'
		],
		'remember' => [
			'cookie_name' => 'xxx',
			'cookie_expiry' => 'xxx'
		],
		'session' => [
			'session_name' => 'xxx',
			'token_name' => 'xxx'
		]
	];
	
	//convert any html symbol
	//into allowable characters
	function escape($string){
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}
	
	//load the classes
	spl_autoload_register(function($class){
		require_once SITE_ROOT . DS . 'includes' . DS . 'classes' . DS . $class . '.php';
	});
	
?>