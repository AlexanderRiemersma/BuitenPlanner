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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
    <div class="container mt-5  ">
        <div class="row" >
            <div class=" bg-info col pl-2 pt-2 rounded text-center" >
                <h4> <?php echo 'Welkom bij het activiteiten overzicht ', $name;?>!</h4>
            </div>
        </div>
    </div>

    <table class="table table-striped bg-light rounded mt-4" >

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
            echo "<td><a href='editActivity.php?id=$activity[activity_ID]'>Bewerken</a>/ <a href='delete.php?id=$activity[activity_ID]'>Verwijderen</a> </td></tr>";


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
                        <input type="text"  required class="form-control border border-primary " name="name"  placeholder="Vissen / Wandelen / Fietsen">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="place" class="form-label">Plaats</label>
                        <input type="text"disabled class="form-control border border-primary" name="place"  placeholder="<?php echo $location ?>" value="<?php  $location ?>">
                    </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="duration" class="form-label">Duur</label>
                        <input  type="time"  required class="form-control border border-primary" name="duration"  >
                    </div>

                        <div class="form-group col-md-6">
                            <?php
                            if ($premium == 0){
                                echo '<label for="disabledTextInput" class="form-label">Herhaling</label>
                        <input type="number" id="disabledTextInput" class="form-control" placeholder="1" > ';



                            }else{
                                echo '<label for="repeat" class="form-label">Herhaling</label>
                        <input  type="number"  min="1" required class="form-control border border-primary" name="repeat"  value="1" placeholder="1" >';
                            }
                            ?>
                    </div>
                    </div>

                    <div class="form-row">

                    <div class="form-group col-md-3">
                        <label  class="form-label">Tempratuur </label>
                        <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_temp_c"  >
                    </div>
                        <div class="form-group col-md-3">
                            <label  class="form-label">&#32; °C</label>
                            <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_temp_c"  >
                        </div>


                        <div class="form-group col-md-3">
                            <label  class="form-label">Gevoel </label>
                            <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_feelslike_c"  >
                        </div>
                        <div class="form-group col-md-3">
                            <label  class="form-label"> &#32; °C</label>
                            <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_feelslike_c"  >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label  class="form-label">Wind snelheid </label>
                            <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_wind_kph"  >
                        </div>
                        <div class="form-group col-md-3">
                            <label  class="form-label"> &#32; Km/u</label>
                            <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_wind_kph"  >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="feelslike_c" class="form-label">Wind richting</label>
                            <select class="form-select border-primary" name="wind_dir" aria-label="Wind_dir">
                                <option value="0" selected>Kies een windrichting</option>
                                <option value="N">N</option>
                                <option value="E">O</option>
                                <option value="S">Z</option>
                                <option value="W">W</option>

                                <option value="NNE">NNO</option>
                                <option value="NE">NO</option>
                                <option value="ENE">ONO</option>
                                <option value="ESE">OSO</option>

                                <option value="SE">ZO</option>
                                <option value="SSE">ZZO</option>
                                <option value="SSW">ZZW</option>
                                <option value="SW">ZW</option>

                                <option value="WSW">WZW</option>
                                <option value="WNW">WNW</option>
                                <option value="NW">NW</option>
                                <option value="NNW">NNW</option>
                            </select>


                        </div>


                    </div>

                    <div class="form-row">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label  class="form-label">Neerval </label>
                                <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_precip_mm"  >
                            </div>
                            <div class="form-group col-md-3">
                                <label  class="form-label"> &#32; mm</label>
                                <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_precip_mm"  >
                            </div>

                            <div class="form-group col-md-3">
                                <label  class="form-label">Wolkenveld </label>
                                <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_cloud"  >
                            </div>
                            <div class="form-group col-md-3">
                                <label  class="form-label"> &#32; %</label>
                                <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_cloud"  >
                            </div>
                        </div>
<br>
                            </div>
                            <input type="hidden" name="email" value="<?php $email; ?>">
                            <input type="hidden" name="userid" value="<?php $user_ID; ?>">
                                <br>
            <div class="modal-footer">
                <button type="submit" name="Submit" class="btn btn-primary">Toevoegen</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
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
