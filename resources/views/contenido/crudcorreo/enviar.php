<?php

include("PHPMailer/PHPMailer/PHPMailer.php");
include("PHPMailer/PHPMailer/SMTP.php");
include("PHPMailer/PHPMailer/Exception.php");

try {

	$emailTo = $_POST["correoP"];
	$subject = $_POST["asunto"];
	$mailContent = $_POST["mensaje"];


	$fromemail = $_POST["correoD"];
	$fromname = $_POST["nombre"];
	$host = "mail.supermarketmb.com";
	$port = "25";
//	$SMTPAuth = "login";
//	$SMTPSecure = "tls";
//	$password = "123456";

	$mail = new PHPMailer\PHPMailer\PHPMailer();

	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = $host;
	$mail->Port = $port;
	$mail->SMTPAuth = false;
	$mail->SMTPAutoTLS = false;
	$mail->SMTPSecure = false;
//	$mail->Username = $fromemail;
//	$mail->Password = $password;

	$mail->setFrom($fromemail, $fromname);
	$mail->addAddress($emailTo);

	$mail->Subject = $subject;
	$mail->isHTML(true);

	$mail->Body = $mailContent;

	if (!$mail->send()) {
			echo "<h1>ERROR no se pudo enviar su mensaje!!!</h1>";
			header ("refresh:5; url=index.html");die();
		    }
			echo "<h1>Felicidades tu mensaje se envio con éxito!!!</h1>";
			header ("refresh:5; url=index.html");die(); 
} catch(Exception $e){
		    }
?>
