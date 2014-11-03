<?php

class Back_form {

	function  to_mail($to = array(), $from_email = '', $from_name = '', $subject = '', $body = '') {

		require $_SERVER['DOCUMENT_ROOT'].'/class.phpmailer.php';
		$mail = new PHPMailer();

		$mail->CharSet = 'utf-8';

		$mail->From = $from_email;
		$mail->FromName = $from_name;

		$mail->isHTML(true);  
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = strip_tags($body);

		foreach((array)$to as $email) {
			//Recipients will know all of the addresses that have received a letter
			$mail->addAddress($email, '');
		}
		 
		if(!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}
}

 
$back_form = new back_form();

$back_form->to_mail();

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PHPMailer - mail() test</title>
</head>
<body>

</body>
</html>
