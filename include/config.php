<?php
$servername = "localhost";
$username = "deb85590_buitenplanner";
$password = '$KT^8L4qiRDL!e';
$dbname = "deb85590_buitenplanner";

$dbhost = 'localhost';
$dbuser = 'deb85590_buitenplanner';
$dbpass = '$KT^8L4qiRDL!e';
$dbname = 'deb85590_buitenplanner';


/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'deb85590_buitenplanner');
define('DB_PASSWORD', '$KT^8L4qiRDL!e');
define('DB_NAME', 'deb85590_buitenplanner');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
