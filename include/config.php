<?php
error_reporting(E_ALL & ~E_NOTICE);

require_once 'twig/lib/Twig/Autoloader.php';

define('SIGNATURE', 'hlfVbmIHGPtXSkpaCXFmn6ocXa!5wsF+');

$config['db_host'] = "localhost";
$config['db_user'] = "user";
$config['db_pass'] = "user";
$config['db_name'] = "plantlife";
$config['db_prefix'] = "";

$controllers = array(
    'BaseController',
    'DefaultController',
    'AdminController',
    'LoginController'
    );

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('skeleton');
$twig = new Twig_Environment($loader);
?>
