<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Librerias/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

//$mail = new PHPMailer(true);

$mail = new PHPMailer();
		
$mail->PluginDir = "includes/";

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.openmulita.com';                  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';                                     //SMTP username
    $mail->Password   = '';                                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->From		= '';
	$mail->FromName = 'Test Mail Hoy';
    //Recipients
    $mail->addAddress('damisintesis109@hotmail.com'); 
    $mail->addAddress('augusto6ferrari@hotmail.com');    //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Soy un mail';
    $Body    = 'Soy mail que enviamos clase <b>in bold!</b>';  

    strip_tags(htmlspecialchars($Body));
	$mail->Body = "$Body";

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $exito = $mail->Send();
    print_r($exito);

    $intentos=1;
	while ((!$exito) && ($intentos < 5)) {
		sleep(5);
		echo $mail->ErrorInfo;
		$exito = $mail->Send();
		$intentos=$intentos+1;		
	}
		
	$respuesta = array();
	if(!$exito){
		echo 'Error al intentar enviar el mail';
	}else{
		echo 'Se envio el mail';			
	} 

    

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




?>


