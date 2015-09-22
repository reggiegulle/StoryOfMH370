<?php
	session_start();

	//Define core paths
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	
	defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:' . DS . 'XAMPP' . DS . 'htdocs' . DS . 'mh370');
	
	defined('HTTP') ? null : define('HTTP', ($_SERVER['SERVER_NAME'] == 'localhost') ? 'http://localhost/mh370/' : null);
	
	//store necessary values in the GLOBAL session
	$GLOBALS['config'] = [
		'mysql' => [
			'host' => '127.0.0.1',
			'username' => 'reggiegulle',
			'password' => 'Kwisatz01@kartadalH',
			'db' => 'mh370'
		],
		'remember' => [
			'cookie_name' => 'hash',
			'cookie_expiry' => '604800'
		],
		'session' => [
			'session_name' => 'user',
			'token_name' => 'token'
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