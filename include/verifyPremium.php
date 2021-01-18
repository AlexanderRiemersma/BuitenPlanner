<?php

if(isset($_GET['pkey'])){
    $pkey =$_GET['pkey'];


    $mysqli = NEW MySQLi ('localhost','deb85590_buitenplanner','$KT^8L4qiRDL!e','deb85590_buitenplanner');

    $resultSet = $mysqli->query("SELECT premium, vkey FROM users WHERE premium = 0 AND pkey = '$pkey' LIMIT 1 " );

    if ($resultSet->num_rows == 1){
        $update = $mysqli->query("UPDATE users SET premium = 1 WHERE pkey = '$pkey' LIMIT 1 ");
        if ($update){
            $message = " <div class='container' >  <div class='alert alert-danger' role='alert'>Dit account is niet geregistreert of al geferifieerd! Klik <a href='../index.php'>hier</a> om naar de login pagina te gaan </div></div> ";

        }else{
            echo 'er ging iets mis';
            echo $mysqli->error;
        }
    }else{
        $message = "<div class='container' >  <div class='alert alert-success' role='alert'>U premium account is geferivieerd! Klik <a href='../index.php'>hier</a> om terug te gaan  </div></div> " ;

    }
}else{
    die("oeps er is iets mis gegaan");
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

    <link rel="stylesheet" href="../css/stylesheet.css">

    <title>message</title>
</head>
<body class="bg">
<div style="text-align: center; margin-top: 25%">

    <?php
    echo $message;


    ?>
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
