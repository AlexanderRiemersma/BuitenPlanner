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
include 'db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();
$user_ID = $account['user_ID'];

$delete = $db->query('DELETE FROM users WHERE email = ? ', $_SESSION['name']);

$deleteActivity = $db->query('DELETE  FROM activity WHERE user_ID = ? ', $user_ID);
if($delete){
    // send email to notify
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
        $mail->addAddress($_SESSION['name']);     // Add a recipient
        //    $mail->addAddress('ellen@example.com');               // Name is optional
        //    $mail->addReplyTo('info@example.com', 'Information');
        //    $mail->addCC('cc@example.com');
        //    $mail->addBCC('bcc@example.com');
        // Attachments
        //    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'BuitenPlanner account verwijderd';
        $mail->Body = 'bedankt voor het gebruiken van de buitenplanner app. wij hopen u snel weer te zien. u account is verwijderd!';
        $mail->AltBody = 'bedankt voor het gebruiken van de buitenplanner app. wij hopen u snel weer te zien. u account is verwijderd!';

        $mail->send();
        $error = "x";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


}
$db->close();


?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/stylesheet.css">

    <title>Success</title>
</head>
<body class="bg">
<div style="text-align: center; margin-top: 25%">
    <div class='container' >  <div class='alert alert-success' role='alert'>U account is succesvol verwijderd! Klik <a href='../index.php'>hier</a> om terug te gaan  </div></div>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
