<?php
include 'include/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader

require 'vendor/autoload.php';
$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

$accounts = $db->query('SELECT * FROM localwheater, activity')->fetchAll();

foreach ($accounts as $account) {
//    echo $account['place'] , $account['temp_c'] ,$account['feelslike_c'] , $account['wind_kph']  . '<br>';

    //UserData
    $email = $account['email'];



    //ALL THE LOCAL WEATHER DATA

    //common data
//    $repeat = $account['repeat_activity'];
    $L_place = $account['place'];
    $L_temp_c = $account['temp_c'];
    $L_feelslike_c = $account['feelslike_c'];
    $L_wind_kph = $account['wind_kph'];
    $L_wind_dir = $account['wind_dir'];

    //advanced data
    $L_wind_degree = $account['wind_degree'];
    $L_pressure_mb = $account['pressure_mb'];
    $L_precip_mm = $account['precip_mm'];
    $L_cloud= $account['cloud'];
    $L_humidity = $account['humidity'];
    $L_uv= $account['uv'];
    $L_gust_kph = $account['gust_kph'];

    //ALL THE ACTIVITY DATA

    //common data
    $nameActivity = $account['name_activity'];
    $repeat = $account['repeat_activity'];
    $user_ID = $account['user_ID'];
    $A_place = $account['place_activity'];
    $A_temp_c = $account['temp_c_activity'];
    $A_feelslike_c = $account['feelslike_c'];
    $A_wind_kph = $account['wind_kph_activity'];
    $A_wind_dir = $account['wind_dir_activity'];

    //advanced data
    $A_wind_degree = $account['wind_degree_activity'];
    $A_pressure_mb = $account['pressure_mb_activity'];
    $A_precip_mm = $account['precip_mm_activity'];
    $A_cloud= $account['cloud_activity'];
    $A_humidity = $account['humidity_activity'];
    $A_uv= $account['uv_activity'];
    $A_gust_kph = $account['gust_kph_activity'];

    //check if common data matches
    if (($A_place = $L_place)  && ($A_temp_c == $L_temp_c ) && ($A_feelslike_c == $L_feelslike_c) && ($A_wind_kph == $L_wind_kph) &&($A_wind_dir == $L_wind_dir) ){
        echo 'ja bij ' , $email, '<br>';
//send mail
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
            $mail->Subject = 'BuitenPlanner | uitvoeren activiteit';
            $mail->Body = 'U kunt de activiteit '.$nameActivity.' nu uitvoeren';
            $mail->AltBody = 'uitvoeren activitei';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }


}

//get repeat data

//if repeatdata = 0 delete activity

//else update repeat to -1
