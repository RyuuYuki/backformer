<?php

/**
* Backformer - simple ajax webform.
*
* @author Rugoals <rugoasl@gmail.com>
* @license Apache 2.0
* @link https://github.com/Rugoals/backformer/
* @version 2.0
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

$config['name']= isset($_POST['bf-config']) ? preg_replace ("/[^a-zA-Z0-9_\-]/","", $_POST['bf-config']) : 'default'; 

if (!empty($config['name']) && file_exists(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php')) {
	require_once(PATH_BACKFORMER.'configs/'.$config['name'].'/config.php');
	require_once(PATH_BACKFORMER.'core/lexicon/'.$config['used_lang'].'.php');
	require_once(PATH_BACKFORMER.'core/model/backformer.class.php');
	$backformer = new backformer($config, $lang);
	echo $backformer->send();
}
	

 
 
?>
 
