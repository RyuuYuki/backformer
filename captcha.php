<?php 

include('core/libraries/kcaptcha/kcaptcha.php');

session_start();

$captcha = new KCAPTCHA();
$_SESSION['captcha_keystring'] = $captcha->getKeyString();


?>