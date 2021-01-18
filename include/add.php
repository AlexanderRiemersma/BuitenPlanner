<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
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


    //declaring variables
    $nameActivity = ucfirst($_POST['name']);
    $placeActivity = ucfirst($_POST['place']);
    $durationActivity = $_POST['duration'];

    $repeat = $_POST['repeat'];
    $temp_c = $_POST['temp_c'];
    $feelC = $_POST['feelC'];

    $wind_kph = $_POST['wind_kph'];
    $wind_degree = $_POST['wind_degree'];
    $cloud = $_POST['cloud'];

    $wind_dir = $_POST['wind_dir'];
    $humidity = $_POST['humidity'];
    $presure_mb = $_POST['presure_mb'];

    $uv = $_POST['uv'];
    $gust_kph = $_POST['gust_kph'];
    $precip_mm = $_POST['precip_mm'];


    //database conection
    $mysqli = NEW MySQLi ('localhost', 'deb85590_buitenplanner', '$KT^8L4qiRDL!e', 'deb85590_buitenplanner');

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $nameActivity = $mysqli->real_escape_string($nameActivity);
    $placeActivity = $mysqli->real_escape_string($placeActivity);
    $durationActivity = $mysqli->real_escape_string($durationActivity);

    $temp_c = $mysqli->real_escape_string($temp_c);
    $feelC = $mysqli->real_escape_string($feelC);
    $wind_kph = $mysqli->real_escape_string($wind_kph);

    $wind_degree = $mysqli->real_escape_string($wind_degree);
    $cloud = $mysqli->real_escape_string($cloud);
    $wind_dir = $mysqli->real_escape_string($wind_dir);

    $humidity = $mysqli->real_escape_string($humidity);
    $uv = $mysqli->real_escape_string($uv);
    $gust_kph = $mysqli->real_escape_string($gust_kph);
    $precip_mm = $mysqli->real_escape_string($precip_mm);


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

    $sql = ("INSERT INTO activity (user_ID, name_activity, place_activity, duration_activity, repeat_activity, temp_c_activity, uv_activity, wind_kph_activity, wind_degree_activity, wind_dir_activity, cloud_activity, humidity_activity, gust_kph_activity, feelslike_c_activity, pressure_mb_activity , precip_mm_activity, email) VALUES ('$user_ID','$nameActivity','$placeActivity','$durationActivity','$repeat','$temp_c','$uv','$wind_kph','$wind_degree','$wind_dir','$cloud','$humidity','$gust_kph','$feelC','$presure_mb','$precip_mm','$email')");

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
if ($sql){
    //add location to Local weather if not exist
    $servername = "localhost";
    $username = "deb85590_buitenplanner";
    $password = '$KT^8L4qiRDL!e';
    $dbname = "deb85590_buitenplanner";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = ("INSERT INTO localwheater (place) VALUES ('$placeActivity' )");
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

    header('Location: createActivity');


    $mysqli->close();
} else {
    echo 'broken';
    echo("Error description: " . $mysqli->error);
}

