<?php 

require_once 'core/libraries/rugoals/kcaptcha/kcaptcha.php';
session_start();

$captcha = new KCAPTCHA();
$_SESSION['captcha_keystring'] = $captcha->getKeyString();


?>