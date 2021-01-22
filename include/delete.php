<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.php');
    exit;
}



//connecting to the database
include 'db.php';

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);
//get activity and check



if (isset($_GET['id'])) {
    $databaseHost = 'localhost';
    $databaseName = 'deb85590_buitenplanner';
    $databaseUsername = 'deb85590_buitenplanner';
    $databasePassword = '$KT^8L4qiRDL!e';

    $mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    $id =  $_GET['id'];
    $email = $_SESSION['name'];

    $check = $db->query('SELECT * FROM activity WHERE activity_ID = ? AND email = ?', $id, $_SESSION['name']);
//   echo  $check->numRows();

if ($check->numRows() == 1){
    // sql to delete a record
    $sql = "DELETE FROM activity WHERE  activity_ID=" . (int)$_GET['id'] ;
    $result = mysqli_query($mysqli, $sql);
        header('Location: createActivity.php');
}else{
    echo 'jij mag dit niet aanpassen';
    header('Location: createActivity.php');

}

}

else{
   echo 'Er is iets fout gegaan! ';
}
