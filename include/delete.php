<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {
    $databaseHost = 'localhost';
    $databaseName = 'deb85590_buitenplanner';
    $databaseUsername = 'deb85590_buitenplanner';
    $databasePassword = '$KT^8L4qiRDL!e';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    // sql to delete a record
    $sql = "DELETE FROM activity WHERE activity_ID=" . (int)$_GET['id'];
    $result = mysqli_query($mysqli, $sql);

    header('Location: createActivity.php');
}

else{
   echo 'Er is iets fout gegaan! ';
}
