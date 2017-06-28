<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once 'twig/lib/Twig/Autoloader.php';

define('SIGNATURE', 'hlfVbmIHGPtXSkpaCXFmn6ocXa!5wsF+');

$config['db_host'] = "";
$config['db_user'] = "";
$config['db_pass'] = "";
$config['db_name'] = "";
$config['db_prefix'] = "";

$controllers = array(
	'BaseController',
	'DefaultController',
	'PanelController',
	'BugController',
	'LostController',
	'LoginController',
	'ContactController',
	'NewsController'
	);

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('skeleton');
$twig = new Twig_Environment($loader);
?>
