<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';
include 'db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];
$user_ID = $account['user_ID'];

$error = null;

if (isset($_POST['submit'])) {
    //get the form data
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    //check if new passwords mach
//check if the password is long enough
    if (strlen($password1) < 5) {
        $error = "<div class='container' style='max-width: 600px; margin-top: 10px'> <div class='alert alert-danger' role='alert'>Het wachtwoord is te kort -minimaal 5 caracters</div> </div>";
    } elseif ($password1 != $password2) {
        $error .= "<div class='container' style='max-width: 600px; margin-top: 10px'>  <div class='alert alert-danger' role='alert'>De wachtwoorden komen niet overeen</div></div>";
    } else {
        //database conection
        $mysqli = NEW MySQLi ('localhost', 'deb85590_buitenplanner', '$KT^8L4qiRDL!e', 'deb85590_buitenplanner');

        //prevent sql injecties
        $password1 = $mysqli->real_escape_string($password1);

        //insert in database
        $password = md5($password1);

        $insert = $mysqli->query("UPDATE users SET password = '$password' WHERE user_ID ='$user_ID' ");
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
                $mail->Subject = 'BuitenPlanner Wachtwoord veranderd';
                $mail->Body = 'Het wachtwoord is gewijzigt ';
                $mail->AltBody = 'Het wachtwoord is gewijzigt';

                $mail->send();
//                $error = "<div class='container' style='max-width: 600px;'>  <div class='alert alert-success' role='alert'>De verificatie mail is verstuurd</div></div>";

                session_start();
                session_destroy();
// Redirect to the login page:
                header('Location: ../index.php');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }else{
            echo $mysqli->error;
        }

    }
}
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


    <!-- custom stylesheet -->
    <link rel="stylesheet" href="../css/stylesheet.css">

    <title>Verander wachtwoord</title>

    <script src="maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<body>
</head>
<body class="bg">

<div class="login-form form-middle" >
    <form action="" method="post" >
        <h4 class="text-center">Verander wachtwoord</h4>
        <br>
        <div class="form-group">
            <input required type="password" name="password1" id="password1" class="form-control" placeholder="Nieuw wachtwoord">
        </div>
        <br>
        <div class="form-group">
            <input required type="password" name="password2" id="password2" class="form-control" placeholder="Bevestig wachtwoord">
        </div>
        <br>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info btn-md" value="Verander">
            <a class="ml-5" href="../dashboard.php">annuleer</a>
        </div>

<?php echo $error?>
    </form>

</div>
</body>

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
