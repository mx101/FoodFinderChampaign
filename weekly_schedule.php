<?php
session_start();
include("config.php");


$servername = "foodfinderdatabase.cftnyz75hjki.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "CS411uiuc";
$dbname = "foodfinderdatabase";

$User_ID = $_SESSION['login_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Mon_DishName, Tue_DishName, Wed_DishName, Thu_DishName, Fri_DishName, Sat_DishName, Sun_DishName FROM foodfinderdatabase.weekly_schedule w INNER JOIN foodfinderdatabase.users ON w.ScheduleID = users.UserID WHERE users.UserID = '$User_ID'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $Monday_dish = $row["Mon_DishName"];
        $Tuesday_dish = $row["Tue_DishName"];
        $Wednesday_dish = $row["Wed_DishName"];
        $Thursday_dish = $row["Thu_DishName"];
        $Friday_dish = $row["Fri_DishName"];
        $Saturday_dish = $row["Sat_DishName"];
        $Sunday_dish = $row["Sun_DishName"];
    }
} else {
    echo "0 results";
}

if($_POST['clear']) {
  $sql1 = "DELETE Mon_DishName, Tue_DishName, Wed_DishName, Thu_DishName,
  Fri_DishName, Sat_DishName, Sun_DishName From weekly_schedule
  WHERE ScheduleID = '$User_ID';";
  mysqli_query($db, $sql1);
  $warning = "All data cleared.";
}

$conn->close();
?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Weekly Schedule</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
  </head>
  <body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="limiter">
      <div class="container-table100">
        <div class="wrap-table100">
          <div class="container-table-form-btn">
            <a class="table-form-btn" href="search.php">
              ADD
            </a>
          </div>
          
            <div class="container-table-form-btn">
              <input class="table-form-btn" type="submit" name="clear" value="CLEAR">
            </div>
          
          <div style = “font-size:11px; color:#cc0000; margin-top:10px”><?php echo $warning; ?></div>

        </br>

          <div class="table100 ver5 m-b-110">
            <table data-vertable="ver5">
              <thead>
                <tr class="row100 head">
                  <th class="column100 column2" data-column="column2" style="text-align:center">Monday</th>
                  <th class="column100 column3" data-column="column3" style="text-align:center">Tuesday</th>
                  <th class="column100 column4" data-column="column4" style="text-align:center">Wednesday</th>
                  <th class="column100 column5" data-column="column5" style="text-align:center">Thursday</th>
                  <th class="column100 column6" data-column="column6" style="text-align:center">Friday</th>
                  <th class="column100 column7" data-column="column7" style="text-align:center">Saturday</th>
                  <th class="column100 column8" data-column="column8" style="text-align:center">Sunday</th>
                </tr>
              </thead>

              <!--COMMENT: The body of the table.-->
              <tbody>
                <tr class="row100">
                  <!--COMMENT: Monday. Click it will lead to the search page for monday.-->
                  <td class="column100 column2" data-column="column2" style="text-align:center"> <?php echo $Monday_dish ?> </td>

                  <!--COMMENT: Tuesday. -->
                  <td class="column100 column3" data-column="column3" style="text-align:center"> <?php echo $Tuesday_dish ?> </td>

                  <!--COMMENT: Wednesday. -->
                  <td class="column100 column4" data-column="column4" style="text-align:center"> <?php echo $Wednesday_dish ?> </td>

                  <!--COMMENT: Thursday. -->
                  <td class="column100 column5" data-column="column5" style="text-align:center"> <?php echo $Thursday_dish ?> </td>

                  <!--COMMENT: Friday. -->
                  <td class="column100 column6" data-column="column6" style="text-align:center"> <?php echo $Friday_dish ?> </td>

                  <!--COMMENT: Saturday. -->
                  <td class="column100 column7" data-column="column7" style="text-align:center"> <?php echo $Saturday_dish ?> </td>

                  <!--COMMENT: Sunday. -->
                  <td class="column100 column8" data-column="column8" style="text-align:center"> <?php echo $Sunday_dish ?> </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>






    <!--===============================================================================================-->
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
        <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
        <script src="js/main.js"></script>
   </form>
  </body>
</html>


