<?php

/**
* Backformer - Simple, flexible ajax webform.
*
* @author Rugoals <rugoals@gmail.com>
* @license Apache 2.0
* @link https://github.com/Rugoals/backformer/
* @version 2.5.2
*/

$debug = 1;

if($debug > 0) {
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
}

define("PATH_BACKFORMER", $_SERVER['DOCUMENT_ROOT'].'/backformer/');

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	require_once PATH_BACKFORMER.'core/libraries/twig/twig/lib/Twig/Autoloader.php';
	require_once PATH_BACKFORMER.'core/libraries/phpmailer/phpmailer/PHPMailerAutoload.php'; 
} else {
 	require_once PATH_BACKFORMER.'core/libraries/autoload.php';  
}

session_start();

$config = array();
$lang = array();

$default_config_name = 'default'; 

$config['name'] = isset($_REQUEST['bf-config']) ? preg_replace ("/[^a-z0-9_\-]/i","", $_REQUEST['bf-config']) : ''; 

if(!file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/') || empty($config['name'])) {
	$config['name'] = $default_config_name;
}

require_once(PATH_BACKFORMER.'configs/'.$default_config_name.'/config.php');

//add custom user php class
require_once PATH_BACKFORMER.'core/model/ievents.interface.php'; 
if(!file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/model/events.class.php')) {
	require_once(PATH_BACKFORMER.'configs/'.$default_config_name.'/model/events.class.php');
} else {
	require_once(PATH_BACKFORMER.'configs/'.$config['name'].'/model/events.class.php');
}

//replace default config
if(file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php')) {
	require_once(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php');
}

if(!empty($config['used_lang'])) {
	require_once(PATH_BACKFORMER.'core/lexicon/'.$config['used_lang'].'.php');
}

require_once PATH_BACKFORMER.'core/model/backformer.class.php';

$backformer = new backformer($config, $lang);
echo $backformer->init(); 





	
 
 