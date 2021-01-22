<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

include 'db.php';

require 'config.php';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];
$location = $account['location'];


if (isset($_POST['submit'])) {
    //defining post variables
    $id = $_POST['activityID'];
    $name = $_POST['name'];

    $place = $location;
    $duration = $_POST ['duration'];
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


    //creating connection
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

    //update query
    $sql ="UPDATE activity SET name_activity='$name', place_activity='$place' , duration_activity='$duration', repeat_activity='$repeat', min_temp_c_activity='$min_temp_c', max_temp_c_activity='$max_temp_c' , min_feelslike_c_activity='$min_feelslike_c', max_feelslike_c_activity='$max_feelslike_c', min_wind_kph_activity='$min_wind_kph' , max_wind_kph_activity='$max_wind_kph', wind_dir_activity='$wind_dir', min_precip_mm_activity='$min_precip_mm', max_precip_mm_activity='$max_precip_mm', min_cloud_activity='$min_cloud' , max_cloud_activity='$max_cloud'  WHERE activity_ID='$id' ";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();

    //redirect to read
    header("Location: createActivity.php");

}

