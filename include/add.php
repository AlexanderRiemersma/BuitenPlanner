<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}


$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';


include 'db.php';
require 'config.php';

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$user_ID = $account['user_ID'];
$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];

// Check If form submitted, insert form data into users table.
if (isset($_POST['Submit'])) {

    $nameActivity =  htmlspecialchars(ucfirst($_POST['name']));
    //declaring variables
//    $nameActivity = ucfirst($_POST['name']);
    $placeActivity = $location;
    $durationActivity = $_POST['duration'];

    $repeat = $_POST['repeat'];
    $min_temp_c = $_POST['min_temp_c'];
    $max_temp_c = $_POST['max_temp_c'];

    $min_feelslike_c = $_POST['min_feelslike_c'];
    $max_feelslike_c = $_POST['max_feelslike_c'];

    $min_wind_kph = $_POST['min_wind_kph'];
    $max_wind_kph = $_POST['max_wind_kph'];

    $min_cloud = $_POST['min_cloud'];
    $max_cloud = $_POST['max_cloud'];

    $wind_dir = $_POST['wind_dir'];

    $min_precip_mm = $_POST['min_precip_mm'];
    $max_precip_mm = $_POST['max_precip_mm'];



    //database conection
    $mysqli = NEW MySQLi ('localhost', 'deb85590_buitenplanner', '$KT^8L4qiRDL!e', 'deb85590_buitenplanner');

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $nameActivity = $mysqli->real_escape_string($nameActivity);
    $placeActivity = $mysqli->real_escape_string($placeActivity);
    $durationActivity = $mysqli->real_escape_string($durationActivity);


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

    $sql = ("INSERT INTO activity (user_ID, name_activity, place_activity, duration_activity, repeat_activity, min_temp_c_activity, max_temp_c_activity , min_wind_kph_activity,max_wind_kph_activity, wind_dir_activity, min_cloud_activity, min_feelslike_c_activity, max_feelslike_c_activity, min_precip_mm_activity, email , max_cloud_activity, max_precip_mm_activity) VALUES
                                ('$user_ID','$nameActivity','$placeActivity','$durationActivity','$repeat','$min_temp_c','$max_temp_c','$min_wind_kph','$max_wind_kph','$wind_dir','$min_cloud','$min_feelslike_c','$max_feelslike_c','$min_precip_mm','$email', '$max_cloud','$max_precip_mm')");

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

    header('Location: createActivity');


    $mysqli->close();
} else {
    echo 'broken';
    echo("Error description: " . $mysqli->error);
}

