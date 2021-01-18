<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include 'db.php';
//$dbhost = 'localhost';
//$dbuser = 'root';
//$dbpass = '';
//$dbname = 'buitenplanner';
require 'config.php';
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];
$user_ID = $account['user_ID'];


$db = new db($dbhost, $dbuser, $dbpass, $dbname);


$id = $_GET['id'];


$account = $db->query('SELECT * FROM activity WHERE activity_ID = ? AND user_ID  = ?', $id, $user_ID)->fetchArray();
$name = $account['name_activity'];
$place = $account['place_activity'];
$duration = $account['duration_activity'];
$repeat = $account['repeat_activity'];
$temp_c = $account['temp_c_activity'];
$feelslike_c = $account['feelslike_c_activity'];
$wind_kph = $account['wind_kph_activity'];
$humidity = $account['humidity_activity'];
$wind_dir= $account['wind_dir_activity'];
$presure_mb= $account['pressure_mb_activity'];
$wind_degree= $account['wind_degree_activity'];
$gust_kph= $account['gust_kph_activity'];
$precip_mm= $account['precip_mm_activity'];
$cloud= $account['cloud_activity'];
$uv= $account['uv_activity'];
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


    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <title>Edit activity</title>
</head>


<body class="bg-dash">
<!--navbar-->
<nav class="navbar navbar-secondary bg-light">
    <a class="navbar-brand">Buiten Planner</a>
    <form class="form-inline">
        <!--        <a class="btn btn-outline-success my-2 my-sm-0 mr-4 " data-bs-toggle="modal" data-bs-target="#createActivity">Activiteit toevoegen</a>-->

        <a class="btn btn-outline-success my-2 my-sm-0 mr-4 text-dark" href="createActivity.php">Terug</a>

        <a class="btn btn-outline-danger my-2 my-sm-0 " href="logout.php">uitloggen</a>
    </form>
</nav>
<!--end nav -->
<div class="container bg-white rounded mt-4 pt-5 pb-5 ">
<form method="post" action="edit.php">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name" class="form-label">Naam van de activiteit</label>
            <input type="text" required class="form-control border border-primary " name="name"  value=<?php echo $name; ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="place" class="form-label">Plaats</label>
            <input type="text"required class="form-control border border-primary" name="place"  value=<?php echo $place; ?>>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="duration" class="form-label">Duur</label>
            <input  type="time"  class="form-control border border-primary" name="duration"   value=<?php echo $duration; ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="repeat" class="form-label">Herhaling</label>
            <input  type="number"  class="form-control border border-primary" name="repeat" value=<?php echo $repeat; ?> >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="temp_c" class="form-label">Tempratuur in celcius</label>
            <input  type="number"  class="form-control border border-primary" name="temp_c"  value=<?php echo $temp_c; ?> >
        </div>
        <div class="form-group col-md-6">
            <label for="feelslike_c" class="form-label">gevoelsempratuur in celcius</label>
            <input  type="number"  class="form-control border border-primary" name="feelC" value=<?php echo $feelslike_c; ?> >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="feelslike_c" class="form-label">Windsnelheid in kph</label>
            <input type="number" class="form-control border border-primary" name="wind_kph" value=<?php echo $wind_kph; ?>>
        </div>
        <div class="form-group col-md-6">
            <label for="feelslike_c" class="form-label">Luchtvochtigehid</label>
            <input type="number" name="humidity" class="form-control border border-primary"  value=<?php echo $humidity; ?>>
        </div>
    </div>
    <br>
    <!-- advanced options -->
    <a class="btn btn-primary" data-toggle="collapse" href="#advanced" role="button" aria-expanded="false" aria-controls="collapseExample">
        Geavanceerd
    </a>
    <input type="submit" name="submit" class="btn btn-primary" value="update">

    <div class="collapse" id="advanced">
        <div class="card card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="feelslike_c" class="form-label">Wind richting</label>
                    <input type="text" name="wind_dir" class="form-control border border-primary"  value= "<?php echo $wind_degree; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="feelslike_c" class="form-label">Luchtdruk in MB</label>
                    <input type="number" name="presure_mb" class="form-control border border-primary"  value="<?php echo $presure_mb; ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="feelslike_c" class="form-label">Wind graad</label>
                    <input type="number" class="form-control border border-primary" name="wind_degree"  value="<?php echo $wind_degree; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="feelslike_c" class="form-label">Wind stoten in kph</label>
                    <input type="number" name="gust_kph" class="form-control border border-primary"   value="<?php echo $gust_kph; ?>">
                </div>
            </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="feelslike_c" class="form-label">Neerval in mm</label>
                <input type="number" class="form-control border border-primary" name="precip_mm"  value="<?php echo $precip_mm; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="feelslike_c" class="form-label">Wolkenveld in %</label>
                <input type="number" name="cloud" class="form-control border border-primary"   value="<?php echo $cloud; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="feelslike_c" class="form-label">UV Index</label>
                <input type="number" class="form-control border border-primary" name="uv" value="<?php echo $uv; ?>">
            </div>
</form>
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

