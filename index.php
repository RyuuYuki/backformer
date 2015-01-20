<?php

$debug = 1;
if($debug > 0) {
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
}

session_start();
 
define("PATH_BACKFORMER", $_SERVER['DOCUMENT_ROOT'].'/backformer2/');

$used_config = isset($_POST['bf-config']) ? preg_replace ("/[^a-zA-Z0-9_\-]/","",$_POST['bf-config']) : ''; 


$conf = array();
$lang = array();

if (!empty($used_config) && file_exists(PATH_BACKFORMER.'configs/'.$used_config.'/config.php')) {
	require_once(PATH_BACKFORMER.'configs/'.$used_config.'/config.php');
	require_once(PATH_BACKFORMER.'core/lexicon/'.$conf['used_lang'].'.php');
}
	
require_once(PATH_BACKFORMER.'core/model/backformer.class.php');

$conf['conf_name'] = $used_config;
$backformer = new backformer($conf, $lang);
echo $backformer->send();
 
 
?>
 
