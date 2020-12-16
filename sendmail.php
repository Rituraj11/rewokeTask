<?php
include("config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor1/autoload.php';
$mail = new PHPMailer(true);
$email = $_REQUEST["email"];
$logid = $_REQUEST["logid"];

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'rituraj.bandha1108@gmail.com';                     // SMTP username
    $mail->Password   = 'rituraj11@';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('rituraj.bandha1108@gmail.com');
    
	$mail->addAddress($email);     // Add a recipient

    $getatt = $con->query("SELECT * FROM convert_logs WHERE logid = '$logid'")->fetch_assoc();
    $filename = $getatt['pdffile'];
    // Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment($filename);    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'DOCX to PDF FIle';
    $mail->Body    = '<p>Hello,</p><p>Please Find your PDF File Below.</p>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
header("location: index.php");
?>