<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


function sendemail($reciever, $appno, $time, $dname){
	$mail = new PHPMailer;
	// SMTP configuration
	$mail->isSMTP();
	$mail->Host     = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'amankumar93051@gmail.com';
	$mail->Password = '@iitgoa22#';
	$mail->SMTPSecure = 'tls';
	$mail->Port     = 587;

	$mail->setFrom('amankumar93051@gmail.com', 'Aman Kumar');
	// Add a recipient
	$mail->addAddress($reciever);

	// Email subject
	$mail->Subject = 'Booking Appointment';

	// Set email format to HTML
	$mail->isHTML(true);

	// Email body content
	$mailContent = '
		<h2>Appointment No. :' . $appno . '</h2>
		<p>Your appointment is booked on ' . $time . ' with '. $dname . '</p>';
	$mail->Body = $mailContent;

	// Send email
	if(!$mail->send()){
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}
function reschedule_email($reciever, $appno, $time, $dname){
	$mail = new PHPMailer;
	// SMTP configuration
	$mail->isSMTP();
	$mail->Host     = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'amankumar93051@gmail.com';
	$mail->Password = '@aman22#';
	$mail->SMTPSecure = 'tls';
	$mail->Port     = 587;

	$mail->setFrom('amankumar93051@gmail.com', 'Aman Kumar');
	//$mail->addReplyTo('aman.kumar.16001@gmail.com', 'Aman Kumar');
	// Add a recipient
	$mail->addAddress($reciever);

	// Add cc or bcc 
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	// Email subject
	$mail->Subject = 'Booking Appointment';

	// Set email format to HTML
	$mail->isHTML(true);

	// Email body content
	$mailContent = '
		<h2>Appointment No. :' . $appno . '</h2>
		<p>Your appointment is rescheduled on ' . $time . ' by '. $dname . '. Sorry for the inconvinience.</p>';
	$mail->Body = $mailContent;

	// Send email
	if(!$mail->send()){
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}
?>