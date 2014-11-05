<?php

class Backformer {

	public $conf, $lang;

	function __construct($conf, $lang) {
		$this->conf = $conf;
		$this->lang = $lang;
	}

	public function send($type) {
		$out = array();  

 		switch ($type) {

			case 0:
    			$out = $this->set_form_data();
    		break;

			case 1:
    			$out = $this->set_token();
    		break; 
			
			default: break;
		} 
		return $this->set_json_encode($out);
	}

	private function set_token() {
		$bf_token = md5(uniqid());
		$_SESSION['bf-token'] = $bf_token;
		return array('token' => $bf_token);
	}

	private function set_form_data() {
		$out = array();

		foreach ($_POST as $key => $value) {
			if(is_array($value)) {
				$info[$key] = strip_tags(implode(', ',$value));
			} else {
				$info[$key] = strip_tags($value);
			}
		}

		if($this->check_capcha()) {
			if($this->check_spam()) {
				if($this->check_empty_field()) {

					$to = $this->conf['to'];
					if(!empty($to)) {
 
						$body = $this->parser_template('config/'.$this->conf['conf_name'].'/report.html', $info);
						$subject = empty($subject) ? $this->lang['main']['subject'] : $subject;

						if(
							$this->set_mail(
								$to,
								$this->conf['from_email'], 
								$this->conf['from_name'], 
								$subject, 
								$body
							)
						) {
							$out = array('status' => 1, 'value' => $this->lang['main']['success_email_send']);
							if(isset($_SESSION['captcha_keystring'])) {
								unset($_SESSION['captcha_keystring']);
								unset($_SESSION['bf-token']);
							}
						} else {
							$out = array('status' => 0, 'value' => $this->lang['err']['email_send']);
						}

					} else {
						$out = array('status' => 0, 'value' => $this->lang['err']['email_send']);
					}
				} else {
					$out = array('status' => 0, 'value' => $this->lang['err']['empty']);
				}
			} else {
				$out = array('status' => 0, 'value' => $this->lang['err']['spam']);
			}
		} else {
			$out = array('status' => 0, 'value' => $this->lang['err']['capcha']);
		}
		return $out;
	}

	private function checked_ajax() {
  		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
  		 strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	private function check_capcha() {
		$out = 1;
		$capcha = isset($_POST['capcha']) ? $_POST['capcha'] : '';
		if($this->conf['capcha'] == 1) {
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $capcha){
				$out = 1;
			} else {
				$out = 0;
			}
		}
		return $out;
	}

	private function check_spam() {
		$out = 1;

		if($this->checked_ajax()) { 
		} else {
			$out = 0;
		}

		$token = isset($_POST['bf-token']) ? $_POST['bf-token'] : '';
		$_SESSION['bf-token'] = isset($_SESSION['bf-token']) ? $_SESSION['bf-token'] : 0;

		if(!empty($token) && (strcmp($_SESSION['bf-token'], $token) == 0)) {
			
		} else {
			$out = 0;
		}

		return $out;
	}

	private function check_empty_field() {
		$empty_error = 1;
		if(!empty($this->conf['need_field'])) {
			$this->conf['need_field'] = explode(',', $this->conf['need_field']);
			foreach ($this->conf['need_field'] as $value) {
				$current = isset($_POST[trim($value)]) ? trim($_POST[trim($value)]) : '';
				if(!isset($_POST[trim($value)]) || empty($current)) {
					$empty_error = 0;
				}
			} 
		}
		return $empty_error;
	}

	protected function set_mail($to = '', $from_email = '', $from_name = '',
								$subject = '', $body = '', $files = array('upload_file')) {

		require_once PATH_BACKFORMER.'model/PHPMailer/class.phpmailer.php';
		$mail = new PHPMailer();

		$mail->CharSet = 'utf-8';

		$mail->From = $from_email;
		$mail->FromName = $from_name;

		$mail->isHTML(true);  
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = strip_tags($body);
 
		foreach ($files as $name_file_field) {
			if(isset($_FILES[$name_file_field]["name"])) {
				$files_count = sizeof($_FILES[$name_file_field]["name"]);
 		
 				for ($i = 0; $i <= $files_count - 1; $i++) {	
					if (isset($_FILES[$name_file_field]) && $_FILES[$name_file_field]['error'][$i] == UPLOAD_ERR_OK) {
    					$mail->AddAttachment(
    						$_FILES[$name_file_field]['tmp_name'][$i],
    						$_FILES[$name_file_field]['name'][$i],
    						'base64',
    						$_FILES[$name_file_field]['type'][$i]
    					);
					}
				}
			}
		}
 
		if(!is_array($to)) {
			$to = explode(',', $to);
		} 

		foreach((array)$to as $email) {
			//Recipients will know all of the addresses that have received a letter
			$mail->addAddress($email, '');
		}
	
		return $mail->send();
	}
 
	protected function parser_template($path, $placeholder) {
		$chunk = file_get_contents(PATH_BACKFORMER.$path);
		foreach ($placeholder as $k => $v){
			$chunk = str_replace("[+".$k."+]", $v, $chunk);
		}
		$chunk = preg_replace('/\[\+[0-9a-zA-Z]*\+\]/i', '-', $chunk);
		return $chunk;
	}

	protected function set_json_encode($value) {
		$out = '';
		if (!function_exists('json_encode')) {
			$out = $this->json_encode_callback($value);
		} else {
			$out = json_encode($value);	
		}

		header('Content-type: text/json;  charset=utf-8');
		header('Content-type: application/json');
		return $out;
	}
 
    private function json_encode_callback($value) {
        if (is_int($value)) {
            return (string)$value;   
        } else if (is_string($value)) {
	        $value = str_replace(array('\\', '/', '"', "\r", "\n", "\b", "\f", "\t"), 
	                             array('\\\\', '\/', '\"', '\r', '\n', '\b', '\f', '\t'), $value);
	        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
	        $result = "";
	        for ($i = mb_strlen($value) - 1; $i >= 0; $i--) {
	            $mb_char = mb_substr($value, $i, 1);
	            if (mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) {
	                $result = sprintf("\\u%04x", $match[1]) . $result;
	            } else {
	                $result = $mb_char . $result;
	            }
	        }
	        return '"' . $result . '"';                
        } else if (is_float($value)) {
            return str_replace(",", ".", $value);         
        } else if (is_null($value)) {
            return 'null';
        } else if (is_bool($value)) {
            return $value ? 'true' : 'false';
        } else if (is_array($value)) {
            $with_keys = false;
            $n = count($value);
            for ($i = 0, reset($value); $i < $n; $i++, next($value)) {
                        if (key($value) !== $i) {
			      $with_keys = true;
			      break;
                        }
            }
        } else if (is_object($value)) {
            $with_keys = true;
        } else {
            return '';
        }
        $result = array();
        if ($with_keys) {
            foreach ($value as $key => $v) {
                $result[] = $this->json_encode_old((string)$key) . ':' . $this->json_encode_old($v);    
            }
            return '{' . implode(',', $result) . '}';                
        } else {
            foreach ($value as $key => $v) {
                $result[] = $this->json_encode_old($v);    
            }
            return '[' . implode(',', $result) . ']';
        }
    } 
}
