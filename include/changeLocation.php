<?php
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

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];
$user_ID = $account['user_ID'];

if (isset($_POST['submit'])) {
//get the form data
    $newLocation = $_POST['location'];

//database conection
    $mysqli = NEW MySQLi ('localhost', 'root', '', 'buitenplanner');

//prevent sql injecties
    $newLocation = $mysqli->real_escape_string($newLocation);

//insert in database
    $insert = $mysqli->query("UPDATE users SET location = '$newLocation' WHERE user_ID ='$user_ID' ");

    if ($insert){
        // database insert
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.weatherapi.com/v1/current.json?key=6abbc109d1d8457d9c0130215202411&q=.$newLocation&lang=nl",
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

        curl_close($curl);

        $response = json_decode($response, true);

//defining the variables from api call
        $place = $response['location']['name'];
        $last_updated = $response['current']['last_updated'];
        $temp_c = $response['current']['temp_c'];
        $temp_f = $response['current']['temp_f'];
        $wind_mph = $response['current']['wind_mph'];
        $wind_kph = $response['current']['wind_kph'];
        $wind_degree = $response['current']['wind_degree'];
        $wind_dir = $response['current']['wind_dir'];
        $pressure_mb = $response['current']['pressure_mb'];
        $pressure_in = $response['current']['pressure_in'];
        $precip_mm = $response['current']['precip_mm'];
        $precip_in = $response['current']['precip_in'];
        $humidity = $response['current']['humidity'];
        $cloud = $response['current']['cloud'];
        $feelslike_c = $response['current']['feelslike_c'];
        $feelslike_f = $response['current']['feelslike_f'];
        $vis_km = $response['current']['vis_km'];
        $vis_miles = $response['current']['vis_miles'];
        $uv = $response['current']['uv'];
        $gust_mph = $response['current']['gust_mph'];
        $gust_kph = $response['current']['gust_kph'];
        $last_updated_epoch = $response['current']['last_updated_epoch'];
        $isDay = $response['current']['is_day'];
        $condition_text = $response['current']['condition']['text'];
        $condition_code =  $response['current']['condition']['code'];
        $condition_icon =$response['current']['condition']['icon'];

        $sql = "INSERT INTO localwheater (place, last_updated, last_updated_epoch, temp_c, temp_f , feelslike_c, feelslike_f, wind_mph, wind_kph, wind_degree, 
wind_dir, pressure_mb, pressure_in, precip_in, precip_mm, humidity, cloud,  is_day ,uv, gust_mph, gust_kph , condition_text , condition_code , condition_icon)
VALUES ('$place', '$last_updated', '$last_updated_epoch', '$temp_c', '$temp_f', '$feelslike_c', '$feelslike_f', '$wind_mph', '$wind_kph', '$wind_degree', '$wind_dir', '$pressure_mb'
, '$pressure_in', '$precip_in', '$precip_mm', '$humidity', '$cloud',  '$isDay', '$uv', '$gust_mph', '$gust_kph' , '$condition_text' , '$condition_code' , '$condition_icon') 
ON DUPLICATE KEY UPDATE  last_updated ='$last_updated', last_updated_epoch ='$last_updated_epoch' , temp_c = '$temp_c' , temp_f = '$temp_f' , feelslike_c = '$feelslike_c' ,feelslike_f = '$feelslike_f' ,
 wind_mph = '$wind_mph' , wind_kph = '$wind_kph' , wind_degree = '$wind_degree' , wind_dir = '$wind_dir' , pressure_mb = '$pressure_mb' , pressure_in='$pressure_in',  precip_in = '$pressure_in' ,precip_mm='$precip_mm',humidity='$humidity'
 ,cloud = '$cloud' , is_day='$isDay', uv = '$uv' , gust_mph ='$gust_mph', gust_kph='$gust_kph',condition_text='$condition_text', condition_code='$condition_code', condition_icon='$condition_icon'";
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
        <h4 class="text-center">Verander standaard locatie</h4>
        <br>
        <div class="form-group">
            <input required type="text" name="location" id="location" class="form-control" placeholder="Locatie">
        </div>
        <br>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info btn-md" value="Verander">
            <a class="ml-5" href="../dashboard.php">annuleer</a>
        </div>

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

