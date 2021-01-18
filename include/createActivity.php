<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

//connecting to the database
include 'db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

//getting the user data from database
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$account = $db->query('SELECT * FROM users WHERE email = ? ', $_SESSION['name'])->fetchArray();

$user_ID = $account['user_ID'];
$name = $account['name'];
$email = $account['email'];
$location = $account['location'];
$createdAt = $account['createdate'];
$premium = $account['premium'];

//setting message variables to null
$addButtonWarning = null;
$addButton = null;
$activityCount = null;
$activityCountMessage = null;
//check if premium
if ($premium == 0){
    $totalActivity = $db->query('SELECT * FROM activity  WHERE user_ID = ? ' , $user_ID);
    $activityCount =  $totalActivity->numRows();
$activityCountMessage = '<a> Activiteit '.$activityCount. ' van de 5</a>';
}
//if the user is not premium replace the add button with a alert
if ($activityCount === 5){
    $addButtonWarning = '<div class="alert alert-primary mt-5" role="alert"> Je kan niet meer activiteiten toevoegen. Neem een <a href="premiumCode">Premium </a>  account om meer activiteiten toe te voegen.</div>';
}else{
    $addButton = '<a class="btn btn-outline-success my-2 my-sm-0 mr-4 " data-bs-toggle="modal" data-bs-target="#createActivity">Activiteit toevoegen</a>';
}
?>

<!doctype html >
<html lang = "en" >
<head >
    <!--Required meta tags-->
    <meta charset = "utf-8" >
    <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no" >

    <!--Bootstrap CSS-->
    <link rel = "stylesheet" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity = "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin = "anonymous" >
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">-->

    <!-- Font awesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <!-- custom stylesheet -->
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">

    <title >Activiteit aanmaken</title >
</head >

<body class="bg">
<!--navbar-->
<nav class="navbar navbar-secondary bg-light">
    <a class="navbar-brand">Buiten Planner</a>
    <a> <?php echo $activityCountMessage ?> </a>
    <form class="form-inline">
<!--        <a class="btn btn-outline-success my-2 my-sm-0 mr-4 " data-bs-toggle="modal" data-bs-target="#createActivity">Activiteit toevoegen</a>-->
        <?php echo $addButton;?>
        <a class="btn btn-outline-success my-2 my-sm-0 mr-4 text-dark" href="../dashboard.php">Terug</a>

        <a class="btn btn-outline-danger my-2 my-sm-0 " href="logout.php">uitloggen</a>
    </form>
</nav>
<!--end nav -->



<!--crud table-->
<div class="container">
    <div class="col">
        <?php
             echo $addButtonWarning ;
        ?>
    </div>
</div>
<div class="container text-center">
    <table class="table table-striped bg-light rounded mt-5" >

        <tr>
<!--            <th>ID</th>-->
            <th>Naam activiteit</th>
            <th>Plaats</th>
            <th>Duur</th>
            <th>Herhaling</th>
            <th>Actie</th>

        </tr>
        <?php

        $activitys = $db->query('SELECT * FROM activity WHERE user_ID = ? ', $user_ID)->fetchAll();

        foreach ($activitys as $activity) {
            echo "<tr>";
//            echo "<td>" . $activity['activity_ID'] . "</td>";
            echo "<td>" . $activity['name_activity'] . "</td>";
            echo "<td>" . $activity['place_activity'] . "</td>";
            echo "<td>" . $activity['duration_activity'] . "</td>";
            if ($premium == 1){
                echo "<td>" . $activity['repeat_activity'] . ' keer', "</td>";
            }else{
                echo '<td> N.V.T </td>';
            }

//            echo "<td>" . $activity['herhaling'] . ' keer', "</td>";
            echo "<td><a href='editActivity.php?id=$activity[activity_ID]'>Edit</a>/ <a href='delete.php?id=$activity[activity_ID]'>Verwijderen</a> </td></tr>";


        }
   ?>
    </table>
</div>

<!--modal for creating a new activity-->

<div class="modal fade" id="createActivity" tabindex="-1" aria-labelledby="createActivity" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createActivity">Activiteit maken</h5>
            </div>
            <div class="modal-body">


                <form method="post" action="add.php">
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class="form-label">Naam van de activiteit</label>
                        <input type="text" required class="form-control border border-primary " name="name"  placeholder="Vissen / Wandelen / Fietsen">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="place" class="form-label">Plaats</label>
                        <input type="text"required class="form-control border border-primary" name="place"  placeholder="Sneek">
                    </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="duration" class="form-label">Duur</label>
                        <input  type="time"  class="form-control border border-primary" name="duration"  >
                    </div>
                        <div class="form-group col-md-6">
                        <label for="repeat" class="form-label">Herhaling</label>
                        <input  type="number"  class="form-control border border-primary" name="repeat" >
                    </div>
                    </div>

                    <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="temp_c" class="form-label">Tempratuur in celcius</label>
                        <input  type="number"  class="form-control border border-primary" name="temp_c"  >
                    </div>
                    <div class="form-group col-md-6">
                    <label for="feelslike_c" class="form-label">gevoelsempratuur in celcius</label>
                        <input  type="number"  class="form-control border border-primary" name="feelC" >
                    </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="feelslike_c" class="form-label">Windsnelheid in kph</label>
                        <input type="number" class="form-control border border-primary" name="wind_kph" placeholder="Wind snelheid kph">
                    </div>
                        <div class="form-group col-md-6">
                        <label for="feelslike_c" class="form-label">Luchtvochtigehid</label>
                        <input type="number" name="humidity" class="form-control border border-primary"  placeholder="Luchtvochtigheid">
                    </div>
                    </div>


<br>
<!-- advanced options -->
                    <a class="btn btn-primary" data-toggle="collapse" href="#advanced" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Geavanceerd
                    </a>
                    <button type="submit" name="Submit" class="btn btn-primary">Toevoegen</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>


                    <div class="collapse" id="advanced">
                        <div class="card card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Wind richting</label>
                                    <input type="text" name="wind_dir" class="form-control border border-primary" placeholder="Wind richting">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Luchtdruk in MB</label>
                                    <input type="number" name="presure_mb" class="form-control border border-primary" placeholder="Luchtdruk in MB">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Wind graad</label>
                                    <input type="number" class="form-control border border-primary" name="wind_degree" placeholder="Wind graad">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Wind stoten in kph</label>
                                    <input type="number" name="gust_kph" class="form-control border border-primary"  placeholder="Wind stoten in kph">
                                </div>
                            </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Neerval in mm</label>
                                    <input type="number" class="form-control border border-primary" name="precip_mm" placeholder="Neerval in mm">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">Wolkenveld in %</label>
                                    <input type="number" name="cloud" class="form-control border border-primary"  placeholder="Wolkenveld in %">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="feelslike_c" class="form-label">UV Index</label>
                                    <input type="number" class="form-control border border-primary" name="uv" placeholder="UV Index">
                                </div>
                            <input type="hidden" name="email" value="<?php $email; ?>">
<br>
            </div>
            <div class="modal-footer">

                </form>


            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body >
</html >
