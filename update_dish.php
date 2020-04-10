<?php
$servername = "us-cdbr-iron-east-04.cleardb.net";
$username = "b5819b447375bb";
$password = "4bd1f395";
$dbname = "heroku_da95d60c5d49de6";


$link = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$Price = mysqli_real_escape_string($link, $_REQUEST['Price']);
$DishID = mysqli_real_escape_string($link, $_REQUEST['DishID']);


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE food_dishes SET Price = '$Price' WHERE DishID = '$DishID'";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
    $stmt->execute();

    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>

