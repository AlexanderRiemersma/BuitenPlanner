<?php
$error = NULL;
session_start();
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST['submit'])){
    //get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $location = $_SESSION['location'];
    $location =  substr($location, 0, strpos($location, ","));
    $password2 = $_POST['password2'];
    $name = ucfirst($_POST['name']) ;
    if (strlen($password) < 5 ){
        $error = "<div class='container' style='max-width: 600px; margin-top: 10px'> <div class='alert alert-danger' role='alert'>Het wachtwoord is te kort -minimaal 5 caracters</div> </div>";
    }elseif ($password2 != $password){
        $error .= "<div class='container' style='max-width: 600px; margin-top: 10px'>  <div class='alert alert-danger' role='alert'>De wachtwoorden komen niet overeen</div></div>";
    }else{
        //database conection
        $mysqli = NEW MySQLi ('localhost','deb85590_buitenplanner','$KT^8L4qiRDL!e','deb85590_buitenplanner');
        //prevent sql injection
        $email = $mysqli->real_escape_string($email);
        $password = $mysqli->real_escape_string($password);
        $password2 = $mysqli->real_escape_string($password2);
//        $location = $mysqli->real_escape_string($location);
        $name = $mysqli->real_escape_string($name);

        //generate Vkey
        $vkey = md5(time().$email);

        //insert in database
        $password = md5($password);

        $insert = $mysqli->query("INSERT INTO users (email,password,location,vkey, name) VALUES ('$email' , '$password' , '$location' , '$vkey' , '$name')");

        //insert localwheter for location

       $curl = curl_init();
       $api_url = 'https://api.weatherapi.com/v1/current.json?key=6abbc109d1d8457d9c0130215202411&q=.$location';
        $url = urlencode($api_url);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        //debug option
//              var_dump(curl_getinfo($curl));
        curl_close($curl);

        $response = json_decode($response, true);

//defining the variables from api call
//        $place = $response['name'];
//        $place = $location;
        $place = $_SESSION['location'];
        $place = substr($place, 0, strpos($place, ","));

//        $place = $response['location']['name'];
//        $place = $response['current']['temp_c'];
        $last_updated = $response['current']['last_updated'];
        $temp_c = $response['current']['temp_c'];
        $wind_kph = $response['current']['wind_kph'];
        $wind_degree = $response['current']['wind_degree'];
        $wind_dir = $response['current']['wind_dir'];
        $pressure_mb = $response['current']['pressure_mb'];
        $precip_mm = $response['current']['precip_mm'];
        $humidity = $response['current']['humidity'];
        $cloud = $response['current']['cloud'];
        $feelslike_c = $response['current']['feelslike_c'];
        $uv = $response['current']['uv'];
        $gust_kph = $response['current']['gust_kph'];

        $last_updated_epoch = $response['current']['last_updated_epoch'];
        $isDay = $response['current']['is_day'];
        $condition_text = $response['current']['condition']['text'];
        $condition_code =  $response['current']['condition']['code'];
        $condition_icon =$response['current']['condition']['icon'];

        //insert in localwheater
        $servername = "localhost";
        $username = "deb85590_buitenplanner";
        $password = '$KT^8L4qiRDL!e';
        $dbname = "deb85590_buitenplanner";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

                $sql = "INSERT INTO localwheater (place, last_updated, last_updated_epoch, temp_c , feelslike_c, wind_kph, wind_degree,wind_dir, pressure_mb, precip_mm, humidity, cloud,  is_day ,uv, gust_kph , condition_text , condition_code , condition_icon)
VALUES ('$place', '$last_updated', '$last_updated_epoch', '$temp_c', '$feelslike_c', '$wind_kph', '$wind_degree', '$wind_dir', '$pressure_mb', '$precip_mm', '$humidity', '$cloud',  '$isDay', '$uv', '$gust_kph' , '$condition_text' , '$condition_code' , '$condition_icon')
ON DUPLICATE KEY UPDATE  last_updated ='$last_updated', last_updated_epoch ='$last_updated_epoch' , temp_c = '$temp_c'  , feelslike_c = '$feelslike_c', wind_kph = '$wind_kph' , wind_degree = '$wind_degree' , wind_dir = '$wind_dir' , pressure_mb = '$pressure_mb' ,precip_mm='$precip_mm',humidity='$humidity'
 ,cloud = '$cloud' , is_day='$isDay', uv = '$uv', gust_kph='$gust_kph',condition_text='$condition_text', condition_code='$condition_code', condition_icon='$condition_icon'";
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
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
                $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

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
                $mail->Body = 'Welkom bij de BuitenPlanner app. <a href="https://lesonline.nu/buitenplanner/include/verify.php?vkey='.$vkey.'">Registreer account </a>';
                $mail->AltBody = 'Welkom bij de BuitenPlanner app';

                $mail->send();
                $error = "<div class='container' style='max-width: 600px;'>  <div class='alert alert-success' role='alert'>De verificatie mail is verstuurd</div></div>";

                //sleep
                sleep(5);
                //redirect
                header('Location: index.php');
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

    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <title>Registreer | Buiten Planner</title>
    <script src="maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<body>
</head>
<body class="bg">

<div class="login-form form-middle" >


    <form action="" method="post" >
        <h2 class="text-center">Stap 2. Persoonlijke gegevens</h2>
        <div class="form-group has-error">
            <input required type="email" name="email" id="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <input required type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord">
        </div>
        <div class="form-group">
            <input required type="password" name="password2" id="password" class="form-control" PLACEHOLDER="Herhaal wachtwoord">
        </div>
        <div class="form-group">
            <input required type="text" name="name" id="name" class="form-control" placeholder="Naam">
        </div>
<!--        <div class="form-group">-->
<!--            <input required type="text" name="location" id="location" class="form-control" placeholder="Standaard locatie">-->
<!--        </div>-->
        <P>Standaard locatie: <?php echo $_SESSION['location'] ;?></P>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info btn-md" value="Registreer">
        </div>
        <?php
        echo $error;
        ?>
        <p class="text-center small">Al geregistreerd? <a id="register" href=index.php>Login hier!</a></p>
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
