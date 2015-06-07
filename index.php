<?php

/**
* Backformer - Simple, flexible ajax webform.
*
* @author Rugoals <rugoasl@gmail.com>
* @license Apache 2.0
* @link https://github.com/Rugoals/backformer/
* @version 2.2
*/

$debug = 0;
if($debug > 0) {
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
}

session_start();
 
define("PATH_BACKFORMER", $_SERVER['DOCUMENT_ROOT'].'/backformer/');

$config = array();
$lang = array();

$config['name'] = isset($_REQUEST['bf-config']) ? preg_replace ("/[^a-zA-Z0-9_\-]/","", $_REQUEST['bf-config']) : 'default'; 

if(!file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/')) {
	$config['name'] = 'default';
}

if (!empty($config['name'])) {
	require_once(PATH_BACKFORMER.'configs/default/config.php');

	if(file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php')) {
		require_once(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php');
	}

	if(!empty($config['used_lang'])) {
		require_once(PATH_BACKFORMER.'core/lexicon/'.$config['used_lang'].'.php');
	}

	require_once(PATH_BACKFORMER.'core/model/backformer.class.php');
	$backformer = new backformer($config, $lang);
	echo $backformer->send();
}
 