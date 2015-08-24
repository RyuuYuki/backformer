<?php

/**
* Backformer - Simple, flexible ajax webform.
*
* @author Rugoals <rugoals@gmail.com>
* @license Apache 2.0
* @link https://github.com/Rugoals/backformer/
* @version 2.5
*/

$debug = 0;

if($debug > 0) {
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
}

define("PATH_BACKFORMER", $_SERVER['DOCUMENT_ROOT'].'/backformer/');

require_once PATH_BACKFORMER.'core/libraries/Twig-1.18.1/lib/Twig/Autoloader.php'; 
require_once PATH_BACKFORMER.'core/libraries/PHPMailer/PHPMailerAutoload.php';

session_start();

$config = array();
$lang = array();

$default_config_name = 'default'; 

$config['name'] = isset($_REQUEST['bf-config']) ? preg_replace ("/[^a-zA-Z0-9_\-]/","", $_REQUEST['bf-config']) : ''; 

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





	
 
 