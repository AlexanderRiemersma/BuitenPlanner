<?php
if (isset($_POST['submit'])) {
    //defining post variables
    $id = $_POST['id'];
    $name = $_POST['name'];
    $place = $_POST['place'];
    $duration = $_POST ['duration'];
    $repeat = $_POST['repeat'];
    $temp_c = $_POST['temp_c'];
    $feelslike_c = $_POST['feelC'];
    $wind_kph = $_POST['wind_kph'];
    $humidity = $_POST['humidity'];
    $wind_dir = $_POST['wind_dir'];
    $presure_mb = $_POST['presure_mb'];
    $wind_degree = $_POST['wind_degree'];
    $gust_kph = $_POST['gust_kph'];
    $precip_mm = $_POST['precip_mm'];
    $cloud = $_POST['cloud'];
    $uv = $_POST['uv'];

    //creating connection
    require 'config.php';

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    //update query
    $result = mysqli_query($conn, "UPDATE activity SET name_activity='$name' ,place_activity='$place', duration_activity='$duration', repeat_activity='$repeat', temp_c_activity='$temp_c',feelslike_c_activity='$feelslike_c',wind_kph_activity='$wind_kph' ,humidity_activity='$humidity', wind_degree_activity='$wind_degree', wind_dir_activity='$wind_dir', pressure_mb_activity='$presure_mb', precip_mm_activity='$precip_mm', cloud_activity='$cloud' ,uv_activity='$uv' ,gust_kph_activity='$gust_kph' WHERE activity_ID=$id");

    if ($result){
        //add location to Local weather if not exist
        $servername = "localhost";
        $username = "deb85590_buitenplanner";
        $password = '$KT^8L4qiRDL!e';
        $dbname = "deb85590_buitenplanner";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = ("INSERT INTO localwheater (place) VALUES ('$place' )");
        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    //redirect to read
    header("Location: createActivity.php");

    //if error show error
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }


}
