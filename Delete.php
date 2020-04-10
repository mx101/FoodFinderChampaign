<?php

$servername = "us-cdbr-iron-east-04.cleardb.net";
$username = "b5819b447375bb";
$password = "4bd1f395";
$dbname = "heroku_da95d60c5d49de6";

$link = mysqli_connect($servername, $username, $password, $dbname);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$Restaurant_Name = mysqli_real_escape_string($link, $_REQUEST['Restaurant_Name']);


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM restaurant WHERE Name='$Restaurant_Name'";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>