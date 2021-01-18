<?php
$error = NULL;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

if (isset($_POST['submit'])){

    //get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($password != 'password' ){
        $error = "<div class='container' style='max-width: 600px; margin-top: 10px'> <div class='alert alert-danger' role='alert'>Verkeerd wachtwoord</div> </div>";
    }else{

        //database conection
        $mysqli = NEW MySQLi ('localhost','deb85590_buitenplanner','$KT^8L4qiRDL!e','deb85590_buitenplanner');

        //prevent sql injecties
        $email = $mysqli->real_escape_string($email);
        $password = $mysqli->real_escape_string($password);

        //generate Pkey
        $pkey = md5(time().$email);

        //generate date
        $nextMonth = time() + (30 * 24 * 60 * 60);

        $premiumDate = date('Y-m-d', $nextMonth) ;

        //insert in database
        $password = md5($password);
//        $insert = $mysqli->query("INSERT INTO users ( pkey) VALUES ('$password' , '$pkey' )  WHERE email = '$email' " );
        $insert = $mysqli->query("UPDATE users SET pkey='$pkey' , premiumDate = '$premiumDate' WHERE email ='$email'" );
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
                $mail->Body = 'klik hier om u premium account te activeren. <a href="https://lesonline.nu/buitenplanner/include/verifyPremium.php?pkey='.$pkey.'">Activeer premium account </a> <br> <p>U heeft premium tot '.$premiumDate.' </p>';
                $mail->AltBody = 'Welkom bij de BuitenPlanner premium';

                $mail->send();
                $error = "<div class='container' style='max-width: 600px;'>  <div class='alert alert-success' role='alert'>De verificatie mail is verstuurd</div></div>";
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

    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="icon" type="../image/png" sizes="16x16" href="../images/favicon.png">

    <title>Premium | Buiten Planner</title>
    <script src="maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<body>
</head>
<body class="bg">
<div class="login-form form-middle" >
    <form action="" method="post" >
        <h2 class="text-center">Premium account</h2>
        <div class="form-group has-error">
            <input required type="email" name="email" id="email" class="form-control" placeholder="Email">
        </div>
        <small>Vul hier het gekregen wachtwoord in</small>
        <div class="form-group">
            <input required type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord">
        </div>

        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info btn-md" value="Activeer">
            <a href="../dashboard.php" class="btn btn-info btn-md text-white">Terug</a>
        </div>
        <?php
        echo $error;
        ?>
<!--        <p class="text-center small">Al geregistreerd? <a id="register" href=index.php>Login hier!</a></p>-->
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
