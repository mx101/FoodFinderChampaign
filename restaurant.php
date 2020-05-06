<?php
session_start();
include("config.php");

$servername = "foodfinderdatabase.cftnyz75hjki.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "CS411uiuc";
$dbname = "foodfinderdatabase";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$User_ID = $_SESSION['login_id'];
$keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
$array_result = array();

if($_POST["search"]) {
  $type = mysqli_real_escape_string($db,$_POST['type']);

  if ($type == 'populariy') {
    $sql1 = "SELECT ranking.Name AS name
    FROM (SELECT f.RestaurantID, AVG(f.Popularity) AS avg_pop, COUNT(f.RestaurantID) AS cnt, r.Name
    FROM food_dishes f, restaurant r
    WHERE f.RestaurantID = r.RestaurantID
    GROUP BY f.RestaurantID
    ORDER BY avg_pop DESC
    LIMIT 10) AS ranking;";
  }

  if ($type == 'pricehigh') {
    $sql1 = "SELECT ranking.Name AS name
    FROM (SELECT f.RestaurantID, AVG(f.Price) AS high_price, COUNT(f.RestaurantID) AS cnt, r.Name
    FROM food_dishes f, restaurant r
    WHERE f.RestaurantID = r.RestaurantID
    GROUP BY f.RestaurantID
    ORDER BY high_price DESC
    LIMIT 10) AS ranking;";
  }

  if ($type == 'pricelow') {
    $sql1 = "SELECT ranking.Name AS name
    FROM (SELECT f.RestaurantID, AVG(f.Popularity) AS low_price, COUNT(f.RestaurantID) AS cnt, r.Name
    FROM food_dishes f, restaurant r
    WHERE f.RestaurantID = r.RestaurantID
    GROUP BY f.RestaurantID
    ORDER BY low_price ASC
    LIMIT 10) AS ranking;";
  }

  $result = $conn->query($sql1);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_array()) {
        $array_result[] = $row;
    }
  } else {
    echo "0 results";
  }
}

$conn->close();
?>







</html>
  <head>
    <title>Search Keywords</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,800" rel="stylesheet" />
    <link href="css/search.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/util.css">


  </head>
    <body>
    <div class="s006">
      <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
        <fieldset>
          <legend>Featured Restaurants</legend>

          <select class="select-css-day" name="type">
            <option value="populariy" selected="selected">Populariy</option>
            <option value="pricehigh">Price: High-to-Low</option>
            <option value="pricelow">Price: Low-to-High</option>
          </select>

          </br>
          </br>

          <select class="select-css-dish" size=10>
            <option><?php echo $array_result[0]['name']; ?></option>
            <option><?php echo $array_result[1]['name']; ?></option>
            <option><?php echo $array_result[2]['name']; ?></option>
            <option><?php echo $array_result[3]['name']; ?></option>
            <option><?php echo $array_result[4]['name']; ?></option>
            <option><?php echo $array_result[5]['name']; ?></option>
            <option><?php echo $array_result[6]['name']; ?></option>
            <option><?php echo $array_result[7]['name']; ?></option>
            <option><?php echo $array_result[8]['name']; ?></option>
            <option><?php echo $array_result[9]['name']; ?></option>
          </select>

          <div class="container-login100-form-btn m-t-20">
            <input class="container-login100-form-btn" type="submit" name="search" style="background-color: #fff; text-align: center" value="SEARH">
          </div>

        </br>

          <div class="container-login100-form-btn">
              <a class="container-login100-form-btn" href="weekly_schedule.php">
                BACK
              </a>
          </div>


        </fieldset>
      </form>
    </div>





      <div class="limiter">
        <div class="container-table100">
          <div class="wrap-table100">

          </div>
        </div>
      </div>

    </body>
</html>
