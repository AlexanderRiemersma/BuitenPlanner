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

//$temp_c = $account['temp_c_activity'];
//$feelslike_c = $account['feelslike_c_activity'];
//$wind_kph = $account['wind_kph_activity'];
//$humidity = $account['humidity_activity'];
//$wind_dir= $account['wind_dir_activity'];
//$presure_mb= $account['pressure_mb_activity'];
//$wind_degree= $account['wind_degree_activity'];
//$gust_kph= $account['gust_kph_activity'];
//$precip_mm= $account['precip_mm_activity'];
//$cloud= $account['cloud_activity'];
//$uv= $account['uv_activity'];

$min_temp_c = $account['min_temp_c_activity'];
$max_temp_c = $account['max_temp_c_activity'];

$min_feelslike_c = $account['min_feelslike_c_activity'];
$max_feelslike_c = $account['max_feelslike_c_activity'];

$min_wind_kph = $account['min_wind_kph_activity'];
$max_wind_kph = $account['max_wind_kph_activity'];

$min_cloud = $account['min_cloud_activity'];
$max_cloud = $account['max_cloud_activity'];

$wind_dir = $account['wind_dir_activity'];

$min_precip_mm = $account['min_precip_mm_activity'];
$max_precip_mm = $account['max_precip_mm_activity'];


if ($user_ID != $account['user_ID']){
    header('Location: ../dashboard.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


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
    <div class="container">
    <form method="post" action="edit.php">
        <input type="hidden" name="activityID" value=<?php echo $id; ?>>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name" class="form-label">Naam van de activiteit</label>
                <input type="text"  required class="form-control border border-primary " name="name"  value=<?php echo $name ;?>>
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
                <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_temp_c"  value=<?php echo $min_temp_c; ?>>
            </div>

            <div class="form-group col-md-3">
                <label  class="form-label">&#32; °C</label>
                <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_temp_c" value=<?php echo $max_temp_c; ?>>
            </div>


            <div class="form-group col-md-3">
                <label  class="form-label">Gevoel </label>
                <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_feelslike_c"  value=<?php  echo $min_feelslike_c;?> >
            </div>
            <div class="form-group col-md-3">
                <label  class="form-label"> &#32; °C</label>
                <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_feelslike_c"  value=<?php echo $max_feelslike_c; ?>  >
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <label  class="form-label">Wind snelheid </label>
                <input  type="number" required  class="form-control border border-primary" name="min_wind_kph"  value=<?php echo $min_wind_kph ?> >
            </div>
            <div class="form-group col-md-3">
                <label  class="form-label"> &#32; Km/u</label>
                <input  type="number" placeholder="<?php echo $max_wind_kph?>" required  class="form-control border border-primary" name="max_wind_kph"  value=<?php echo $max_wind_kph ?>>
            </div>
            <div class="form-group col-md-6">
                <label for="feelslike_c" class="form-label">Wind richting</label>
                <select class="form-select border-primary" name="wind_dir" aria-label="Wind_dir"  >
                    <option selected> <?php echo $wind_dir;?></option>
                    <option value="N"> N</option>
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
                <div class="form-group col-md-3">
                    <label  class="form-label">Neerval </label>
                    <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_precip_mm"  value=<?php echo  $min_precip_mm ?>>
                </div>
                <div class="form-group col-md-3">
                    <label  class="form-label"> &#32; mm</label>
                    <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_precip_mm"  value=<?php echo  $max_precip_mm ?>>
                </div>

                <div class="form-group col-md-3">
                    <label  class="form-label">Wolkenveld </label>
                    <input  type="number" placeholder="min" required  class="form-control border border-primary" name="min_cloud"  value=<?php echo  $min_cloud ?>>
                </div>
                <div class="form-group col-md-3">
                    <label  class="form-label"> &#32; %</label>
                    <input  type="number" placeholder="max" required  class="form-control border border-primary" name="max_cloud"  value=<?php echo  $max_cloud ?>>
                </div>

            <br>
        </div>

        <input type="hidden" name="email" value="<?php $email; ?>">
        <input type="hidden" name="userid" value="<?php $user_ID; ?>">

        <br>
        <input class="btn btn-primary " type="submit" name="submit" value="Bijwerken">
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

