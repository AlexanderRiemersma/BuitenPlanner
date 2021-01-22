<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include 'include/db.php';
//
//$dbhost = 'localhost';
//$dbuser = 'root';
//$dbpass = '';
//$dbname = 'buitenplanner';

require 'include/config.php';
//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];


//declaring and calling the weahter now variables
$weather = $db->query('SELECT * FROM localwheater WHERE place = ? ', $location)->fetchArray();
$last_updated = $weather['last_updated'];
$place = $weather['place'];
$temp_c = $weather['temp_c'];
$feelsLike_c = $weather['feelslike_c'];
$wind_speed =  $weather['wind_kph'];
$wind_dir =  $weather['wind_dir'];
$condition_text = $weather['condition_text'];
$condition_icon = $weather['condition_icon'];



$db->close();

// if premium disable premium tab
if ($premium == 1){
    $premiumTab =' <button type="button" class="btn  btn-primary" disabled>Je hebt al premium!</button>
';
}else{
   $premiumTab =' <a type="button" class="btn btn-primary" href="include/premiumCode">Premium account</a>';

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
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Font awesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <title>Dashboard</title>
</head>
<body class="bg-dash" >

<!--navbar-->
<nav class="navbar navbar-secondary bg-light">
    <a class="navbar-brand">Buiten Planner</a>
    <form class="form-inline">
        <a class="btn btn-outline-success my-2 my-sm-0 mr-3" data-toggle="modal" data-target="#profile"">Profiel</a>

        <a class="btn btn-outline-danger my-2 my-sm-0" href="include/logout.php">uitloggen</a>
    </form>
</nav>
<div class="container">
<!--end navbar-->
<div class="container mt-5  ">
    <div class="row" >
        <div class=" bg-info col pl-2 pt-2 rounded text-center" >
            <h4> <?php echo 'Welkom ', $name;?>!</h4>
        </div>
    </div>
</div>

<!--first row-->
<div class="container">
    <div class="row pt-2" >
        <div class="col bg-white rounded pt-2">
            <h3 >Het weer</h3>
            <hr>
                <div class="row">
                    <div class="col">
                        <?php
                          echo '<h4> <i class="fas fa-location-arrow"></i>  ',$place , "</h3>"  ;
                          echo '<p> Het is nu ', $temp_c , '°c </p>';
                          echo '<p> Het voelt als  ', $feelsLike_c , '°c  </p> ';
                          echo '<p> De windsnelheid is   ', $wind_speed , 'km/u </p>';
                          echo '<p> De wind komt uit het ', $wind_dir,  '</p>';

                        ?>
                    </div>
                    <div class="col">
                        <div class="text-center"><img  src="<?php echo $condition_icon?>" alt="icon" > </div>
                        <?php
                        echo '<hr><p class="mt-2 text-center" >   ', $condition_text,  '</p> ' ;
                        ?>
                    </div>

                </div>
            <div class="row">
                <div class="col">
                    <?php
                    echo '<hr><small>Geupdate op  '. $last_updated .'</small>' ,"<br>";
                    ?>
                </div>

            </div>
        </div>

<!--  activity CRUD -->
        <div class="col- ">
            <div class="card text-center ml-2 pb-2 pt-3" style="width: 19rem;">
                <i class="far fa-plus-square fa-10x"></i>
                <div class="card-body">
                    <h5 class="card-title">Activiteiten beheren</h5>
                    <p class="card-text">Beheer de activiteiten.<br>(maken, bekijken, bewerken, verwijderen)   </p>
                    <!-- Button trigger modal activiteit maken -->
<!--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#activiteitMaken">Maken</button>-->
                    <a type="button" class="btn btn-primary" href="include/createActivity">Activiteiten beheren</a>
                </div>
            </div>
        </div>

        <!-- Premium -->
        <div class="col-">
            <div class="card text-center ml-2 pb-2 pt-3" style="width: 19rem;">
                <i class="fas fa-check-double fa-5x"></i>
                <div class="card-body">
                    <h5 class="card-title">Premium</h5><br>
                    <p>Wat heeft de premium funtie te bieden?</p>
                    <p class="card-text">-Meer dan 5 activiteiten </p>
                    <p>-Herhalingen instellen</p>

                    <?php echo $premiumTab; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modals-->

<!--profile modal-->
<div class="modal fade" id="profile" tabindex="-1" aria-labelledby="profile" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profile">Profiel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <strong>Naam: </strong> <?php echo $name;?>
                <br>
                <strong>Email: </strong> <?php echo $email;?>
                <br>
                <strong>Standaard locatie: </strong> <?php echo $location ;?>
                <br>


                <strong>Aangemeld op: </strong> <?php echo $createdAt;?>
                <br>
                <strong>Premium: </strong> <?php if($premium == 1){ echo 'Ja';}else{echo 'Nee';} ?>
                <hr>
                    <!-- code for account deletion -->
                <button class="btn btn-outline-danger mr-5" onclick="deleteAccount()">Verwijder account</button>
                <script>
                    function deleteAccount() {

                        var r = confirm("Weet u het zeker?");
                        if (r == true) {
                            window.location.replace("include/deleteAccount.php");
                        } else {

                        }

                    }

                </script>


                <a class="btn btn-outline-success my-2 my-sm-0 mr-3" href="include/changePassword.php">verander wachtwoord</a>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal activiteit maken-->
<div class="modal fade" id="activiteitMaken" tabindex="-1" aria-labelledby="activiteitMaken" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Activiteit maken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<form method="post">

    <input class="form-control form-control-sm" type="text" placeholder="Naam activiteit"><br>
    <input class="form-control form-control-sm" type="text" placeholder="Locatie" name="locationF"><br>
    <input class="form-control form-control-sm" type="number" placeholder="Tempratuur in °c"><br>
    <input class="form-control form-control-sm" type="number" placeholder="Gevoel tempratuur in °c"><br>
    <input class="form-control form-control-sm" type="number" placeholder="Wind snelheid in km/u"><br>
    <input class="form-control form-control-sm" type="text" placeholder="Wind richting (dropdown)"><br>
    <input type="submit" name="submit">
</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--footer-->
    <div class="container">
        <footer class=" mt-3   text-center rounded" >
            <div class="row background1 rounded  pt-1">
                <div class="col ">
                    <small>Version: 1.1</small>
                </div>
                <div class="col">
                    <p> <strong> By: </strong> Alexander Riemersma</p>
                </div>
                <div class="col">
<!--                    <a href="#">Docs</a>-->
                    Powered by <a href="https://www.weatherapi.com/" title="Free Weather API">WeatherAPI.com</a>
                </div>
            </div>
        </footer>
    </div>

</div>
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
