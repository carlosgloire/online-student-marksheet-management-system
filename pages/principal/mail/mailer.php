<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

$mail = new PHPMailer(true);
//$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "armel.tchoumdjin@gmail.com"; // Your Gmail address
$mail->Password = "hzfwkkmydshpjsnd"; // Your Gmail password

$mail->isHtml(true);

return $mail;