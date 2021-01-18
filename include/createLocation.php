
<?php
//location search
error_reporting(E_ALL ^ E_NOTICE);
$location = null;

$option1 = 'Vul eerst een locatie in ';
$option2 = 'Vul eerst een locatie in ';
$option3 = 'Vul eerst een locatie in ';
$option4 = 'Vul eerst een locatie in ';
$option5 = 'Vul eerst een locatie in ';

session_start();


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

    <title>Registreer | Buiten Planner</title>
    <script src="maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<body>
</head>
<body class="bg">

<div class="login-form form-middle" >

    <form action="checkLocation.php" method="post">
        <h2>Stap 1. Locatie selecteren </h2>
        <label>Zoek een locatie</label>
        <div class="form-row">
            <div class="form-group col-md-10">
                <input  type="text"required name="location" id="location" class="form-control border border-primary" placeholder="Zoek locatie">
            </div>
            <div class="form-group col-md-2">
                <input type="submit"  name="search" value="Zoek" class="btn btn-info btn-md">
            </div>
        </div>
    </form>

    <form method="post">

        <div class="form-group" >
            <select name="ja"  id="location" class="form-select pb-3"  size="2" style="max-width: 250px ">
                <option selected>Zoek eerst een locatie</option>
                <option value="<?= $_SESSION['option1'] ;?>"><?php echo $_SESSION['option1'];?></option>
                <option value="<?= $_SESSION['option2'] ;?>"><?php echo $_SESSION['option2'];?></option>
                <option value="<?= $_SESSION['option3'] ;?>"><?php echo $_SESSION['option3'];?></option>
                <option value="<?= $_SESSION['option4'] ;?>"><?php echo $_SESSION['option4'];?></option>
                <option value="<?= $_SESSION['option5'] ;?>"><?php echo $_SESSION['option5'];?></option>
                <option value="<?= $_SESSION['option6'] ;?>"><?php echo $_SESSION['option6'];?></option>
                <option value="<?= $_SESSION['option7'] ;?>"><?php echo $_SESSION['option7'];?></option>
                <option value="<?= $_SESSION['option8'] ;?>"><?php echo $_SESSION['option8'];?></option>
                <option value="<?= $_SESSION['option9'] ;?>"><?php echo $_SESSION['option9'];?></option>
                <option value="<?= $_SESSION['option10'] ;?>"><?php echo $_SESSION['option10'];?></option>
            </select>
<br>
            <input type="submit"  name="accept" value="Bevestig" class="btn btn-info btn-md mt-5 ">
            <br><br>
            <?php
            $location = null;
            $message = null;
            if (isset($_POST['accept'])){
                $_SESSION['location'] = $_POST['ja'];
                $message = '<p>U locatie is beves. Klik <a style="color: #2389cd;" href="../register.php">hier</a> naar stap 2 te gaan. </p>';
                header('Location: ../register.php');
            }else{
                $message = ' selecteer een locatie!';
            }
            echo $message;
            ?>

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
