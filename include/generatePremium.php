<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

include '../include/db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];

if (isset($_POST['submit'])) {

    //get form data
    $password = $_POST['password'];
}

if ($password == 'moker') {

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
            $mail->Subject = 'BuitenPlanner registratie';
            $mail->Body = '<a> ja de premium werkt soortvan </a>';
            $mail->AltBody = 'Premium';

            $mail->send();
            $error = "<div class='container' style='max-width: 600px;'>  <div class='alert alert-success' role='alert'>De verificatie mail is verstuurd</div></div>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }else {
        $error = 'Wachtwoord is fout';
    }


echo $error;
header('Location: premiumCode.php');
