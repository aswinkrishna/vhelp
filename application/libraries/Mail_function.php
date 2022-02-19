<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

require APPPATH.'third_party/PHPMailer/vendor/autoload.php';


Class Mail_function 
{

    function SendEmail($content,$subject,$to_address,$cc = "", $bcc = "")
    {
     
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function


//Load Composer's autoloader


// $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    
    $this->php_mailer = new PHPMailer(true);
    $t_email  = $to_address;
// 			$domain   = substr($t_email, strpos($t_email, '@') + 1);

// 			if ($domain == "test.com") return true;

			$this->php_mailer->SMTPDebug = 0; 
			$this->php_mailer->isSMTP();
			$this->php_mailer->Host = 'smtp.gmail.com';//EMAIL_HOST;
			$this->php_mailer->SMTPAuth = true;
			$this->php_mailer->Username = '3la3eneuae@gmail.com'; //'vhelpuae2021@gmail.com'; 
			$this->php_mailer->Password = 'Hello@1985'; //'Flower@1989';
			$this->php_mailer->SMTPSecure = 'tls';  // Enable TLS encryption, `ssl` also accepted
			$this->php_mailer->Port = 587;

			$this->php_mailer->setFrom('vhelpuae2021@gmail.com', 'Vhelp');
			$this->php_mailer->addAddress($to_address);
			$this->php_mailer->addReplyTo('vhelpuae2021@gmail.com', 'Vhelp');

// 			$this->php_mailer->addCC($this->from_address);
			if (is_array($cc)) {
				foreach ($cc as $key => $cc_email) {
					if (!empty($cc_email)) {
						$this->php_mailer->addCC($cc_email);
					}
				}
			} else {
				if (!empty($cc)) {
					$this->php_mailer->addCC($cc);
				}
			}

			if (is_array($bcc)) {
				foreach ($bcc as $key => $bcc_email) {
					if (!empty($bcc_email)) {
						$this->php_mailer->addBCC($bcc_email);
					}
				}
			} else {
				if (!empty($bcc)) {
					$this->php_mailer->addCC($bcc);
				}
			}
			/*$this->php_mailer->addBCC("ananthivinay@gmail.com");*/
            /*$this->php_mailer->addBCC("sooraj.a2solution@gmail.com");
            $this->php_mailer->addBCC("aswinkr.a2solution@gmail.com");
            $this->php_mailer->addBCC("dx.nirupam@gmail.com");
            $this->php_mailer->addBCC("dheeraj.a2solutions@gmail.com");*/
			// Attachments
			// $this->php_mailer->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            // $this->php_mailer->addBCC("aswinkr.a2solution@gmail.com");
			
			$this->php_mailer->isHTML(true);
			$this->php_mailer->Subject = $subject;
			$this->php_mailer->Body    = $content;
			$this->php_mailer->AltBody = $content;

			$this->php_mailer->send();
			return true;
} catch (Exception $e) {
//   echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
    }
    
    
}
