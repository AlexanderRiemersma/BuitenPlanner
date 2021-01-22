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
    $L_precip_mm = $account['precip_mm'];
    $L_cloud= $account['cloud'];


    //ALL THE ACTIVITY DATA

    //common data
    $email = $account['email'];
    $nameActivity = $account['name_activity'];
    $activityID = $account['activity_ID'];
    $repeat = $account['repeat_activity'];
    $user_ID = $account['user_ID'];
    $A_place = $account['place_activity'];

    $min_temp_c = $account['min_temp_c_activity'];
    $max_temp_c = $account['max_temp_c_activity'];

    $min_feelslike_c = $account['min_feelslike_c_activity'];
    $max_feelslike_c = $account['max_feelslike_c_activity'];

    $min_wind_kph = $account['min_wind_kph_activity'];
    $max_wind_kph = $account['max_wind_kph_activity'];

    $A_wind_dir = $account['wind_dir_activity'];


    $min_precip_mm = $account['min_precip_mm_activity'];
    $max_precip_mm = $account['max_precip_mm_activity'];

    $min_cloud= $account['min_cloud_activity'];
    $max_cloud= $account['max_cloud_activity'];


    //check if common data matches

    if(($L_place == $A_place) && ($L_temp_c >= $min_temp_c && $L_temp_c <= $max_temp_c) &&($L_feelslike_c >= $min_feelslike_c && $L_feelslike_c <= $max_feelslike_c) && ($L_wind_kph >= $min_wind_kph && $L_wind_kph <= $max_wind_kph)&& ($L_precip_mm >= $min_precip_mm && $L_precip_mm <= $max_precip_mm)&& ($L_cloud >= $min_cloud && $L_cloud <= $max_cloud)){
        echo 'ja bij de plaats  ', $A_place, ' en activiteit  ', $nameActivity, '<br>';

        // send email
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
            $mail->Body = '<a>De activiteit '.$nameActivity.'  kan nu uitgevoerd worden in '.$A_place.'</a>';
            $mail->AltBody = 'Welkom bij de BuitenPlanner app';

            $mail->send();



        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


        echo $repeat , $nameActivity, '<br>';

        if ($repeat == 0){
            $databaseHost = 'localhost';
            $databaseName = 'deb85590_buitenplanner';
            $databaseUsername = 'deb85590_buitenplanner';
            $databasePassword = '$KT^8L4qiRDL!e';

            // Create connection
            $conn = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);
// Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

// sql to delete a record
            $sql = "DELETE FROM activity WHERE activity_ID='$activityID'";

            if ($conn->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }

            $conn->close();
        }else{
            //update to one lower
            // Create connection
            $databaseHost = 'localhost';
            $databaseName = 'deb85590_buitenplanner';
            $databaseUsername = 'deb85590_buitenplanner';
            $databasePassword = '$KT^8L4qiRDL!e';
            $conn = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);
// Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $newRepeat =  $repeat - 1;

            $sql = "UPDATE activity SET repeat_activity='$newRepeat' WHERE activity_ID='$activityID'";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            $conn->close();
        }

}
//    ($L_wind_dir >= $min_temp_c && $L_temp_c <= $max_temp_c)



}

