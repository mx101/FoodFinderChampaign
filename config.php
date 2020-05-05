<?php
$servername = "foodfinderdatabase.cftnyz75hjki.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "CS411uiuc";
$dbname = "foodfinderdatabase";

$db = mysqli_connect($servername, $username, $password, $dbname);
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>