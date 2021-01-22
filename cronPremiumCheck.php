<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
include 'include/db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

//$premiumDate = $accounts['premiumDate'];
$dateNow = date('Y-m-d');

$accounts = $db->query('SELECT * FROM users WHERE premium =1')->fetchAll();
$mysqli = NEW MySQLi ('localhost','deb85590_buitenplanner','$KT^8L4qiRDL!e','deb85590_buitenplanner');


foreach ($accounts as $account) {
    $email = $account['email'];
if ($account['premiumDate'] == $dateNow){
    $insert = $mysqli->query("UPDATE users SET pkey='' , premiumDate = 0 , premium = 0 WHERE email = '$email'" );
echo  'succes ' , $email;
//email notification
    if ($insert){
        // Send email

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
//Server settings
//             $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp-mail.outlook.com';                // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = 'buitenplanner@hotmail.com';                  // SMTP username
            $mail->Password = '@BEbH9^HC#@f';                       // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('buitenplanner@hotmail.com', 'Buitenplanner');
            $mail->addAddress($email);     // Add a recipient
            //    $mail->addAddress('ellen@example.com');               // Name is optional
            //    $mail->addReplyTo('info@example.com', 'Information');
            //    $mail->addCC('cc@example.com');
            //    $mail->addBCC('bcc@example.com');
            // Attachments
            //    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'BuitenPlanner premium';
            $mail->Body = 'U premium is verlopen';
            $mail->AltBody = 'U premium is verlopen';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}
}
