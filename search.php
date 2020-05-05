<?php
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Name</th><th>Price</th><th>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

$servername = "foodfinderdatabase.cftnyz75hjki.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "CS411uiuc";
$dbname = "foodfinderdatabase";

$link = mysqli_connect($servername, $username, $password, $dbname);

$User_Name = mysqli_real_escape_string($link, $_REQUEST['User_Name']);

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM foodfinderdatabase.weekly_schedule w INNER JOIN users ON w.ScheduleID = users.UserID WHERE users.Name = '$User_Name'");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>

<!DOCTYPE HTML>
<html>  
<body>

<form action="update_dish.php" method="post">
    <p>
        <label for="Name">Update Name:</label>
        <input type="text" name="Name" id="Name">
    </p>
    <p>
        <label for="Day">Day:</label>
        <input type="Day" name="Day" id="Day">
    </p>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<!DOCTYPE HTML>
<html>  
<body>

<form action="insert.php" method="post">
    <p>
        <label for="Name">Insert Name:</label>
        <input type="text" name="Name" id="Name">
    </p>
    <p>
        <label for="Day">Day:</label>
        <input type="Day" name="Day" id="Day">
    </p>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<!DOCTYPE HTML>
<html>  
<body>

<form action="delete.php" method="post">
    <p>
        <label for="Name">Delete Name:</label>
        <input type="text" name="Name" id="Name">
    </p>
    <p>
        <label for="Day">Day:</label>
        <input type="Day" name="Day" id="Day">
    </p>
    <input type="submit" value="Submit">
</form>
</body>
</html>



