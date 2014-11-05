<?php

$debug = 0;
if($debug > 0) {
	ini_set('error_reporting', E_ALL);
	ini_set ('display_errors', 1);
}
 
define("PATH_BACKFORMER", $_SERVER['DOCUMENT_ROOT'].'/backformer/');

$used_config = isset($_POST['config']) ? preg_replace ("/[^a-zA-Z0-9_\-]/","",$_POST['config']) : ''; 
$type = isset($_POST['type']) ? intval($_POST['type']) : 0;

$conf = array();
$lang = array();

if (!empty($used_config) && file_exists(PATH_BACKFORMER.'config/'.$used_config.'/config.inc.php')) {
	require_once(PATH_BACKFORMER.'config/'.$used_config.'/config.inc.php');
	require_once(PATH_BACKFORMER.'lexicon/'.$conf['used_lang'].'.php');
}
	
require_once(PATH_BACKFORMER.'model/backformer.class.php');

$conf['conf_name'] = $used_config;
$backformer = new backformer($conf, $lang);
echo $backformer->send($type);
 
 
?>
 
