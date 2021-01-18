<?php

if (isset($_POST['search'])){
    $locatie = $_POST['location'];

    // api call
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.weatherapi.com/v1/search.json?key=6abbc109d1d8457d9c0130215202411&q=.$locatie&lang=nl",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);
//print_r($response) ;
session_start();

    $_SESSION['option1'] = $response[0]['name'];
    $_SESSION['option2'] = $response[1]['name'];
    $_SESSION['option3']= $response[2]['name'];
    $_SESSION['option4']= $response[3]['name'];
    $_SESSION['option5'] = $response[4]['name'];
    $_SESSION['option6'] = $response[5]['name'];
    $_SESSION['option7'] = $response[6]['name'];
    $_SESSION['option8'] = $response[7]['name'];
    $_SESSION['option9'] = $response[8]['name'];
    $_SESSION['option10'] = $response[9]['name'];

};
header( 'location: createLocation.php');


