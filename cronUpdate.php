
<?php
//get all locations saved in database
include 'include/db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

//get locations
$locations = $db->query('SELECT place FROM localwheater')->fetchAll();

foreach ($locations as $location) {
    echo $location['place'];
    $link = "http://api.weatherapi.com/v1/current.json?key=6abbc109d1d8457d9c0130215202411&q=.$location[place]&lang=nl";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$link",
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

//converting response
        $response = json_decode($response, true);

//defining the variables from api call
//        $place = $response['location']['name'];
        $place = $location['place'];
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
        $condition_code = $response['current']['condition']['code'];
        $condition_icon = $response['current']['condition']['icon'];

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

        //insert statement if it exists update
           $sql = "INSERT INTO localwheater (place, last_updated, last_updated_epoch, temp_c , feelslike_c, wind_kph, wind_degree, wind_dir, pressure_mb, precip_mm, humidity, cloud,  is_day ,uv, gust_kph , condition_text , condition_code , condition_icon)
VALUES ('$place', '$last_updated', '$last_updated_epoch', '$temp_c', '$feelslike_c', '$wind_kph', '$wind_degree', '$wind_dir', '$pressure_mb', '$precip_mm', '$humidity', '$cloud',  '$isDay', '$uv', '$gust_kph' , '$condition_text' , '$condition_code' , '$condition_icon') 
ON DUPLICATE KEY UPDATE  last_updated ='$last_updated', last_updated_epoch ='$last_updated_epoch' , temp_c = '$temp_c' , feelslike_c = '$feelslike_c', wind_kph = '$wind_kph' , wind_degree = '$wind_degree' , wind_dir = '$wind_dir' , pressure_mb = '$pressure_mb' ,precip_mm='$precip_mm',humidity='$humidity'
 ,cloud = '$cloud' , is_day='$isDay', uv = '$uv' , gust_kph='$gust_kph',condition_text='$condition_text', condition_code='$condition_code', condition_icon='$condition_icon'";
    //if insert succeed show a succes message

    if ($conn->query($sql) === TRUE) {
        echo '<hr>  ', "success  ",$link , '<br>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    }
