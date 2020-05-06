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
  $error_message1 = "something wrong";

  $sql1 = "SELECT ranking.Name AS Dish_Name , r.Name as Restaurant_Name, ranking.Price AS Price
  FROM restaurant r, (SELECT results.Name, results.Price, SUM(results.points) AS count, results.RestaurantID
  FROM ((SELECT f.Name, f.Price, f.RestaurantID, 5 AS points
    FROM food_dishes f
    WHERE f.Keyword1 = '$keyword'
    OR f.Keyword2 = '$keyword'
    OR f.Keyword3 = '$keyword') UNION ALL
  (SELECT f.Name, f.Price, f.RestaurantID, 5 AS points
    FROM food_dishes f
    WHERE f.Name LIKE CONCAT('%', '$keyword', '%')) UNION ALL
    (SELECT f.Name, f.Price, f.RestaurantID, 3 AS points
    FROM food_dishes f, restaurant r
    WHERE r.RestaurantID = f.RestaurantID
    AND r.Name LIKE CONCAT('%', '$keyword', '%')) UNION ALL
  (SELECT f.Name, f.Price, f.RestaurantID, 3 AS points
    FROM food_dishes f, (SELECT f2.Keyword1, f2.Keyword2, f2.Keyword3
           FROM food_dishes f2, users u
                     WHERE u.UserID = '$User_ID'
                     AND f2.DishID = u.Favorite_Dish) AS keywords
    WHERE f.Keyword1 = keywords.Keyword1
      OR f.Keyword1 = keywords.Keyword2
      OR f.Keyword1 = keywords.Keyword3
      OR f.Keyword2 = keywords.Keyword1
      OR f.Keyword2 = keywords.Keyword2
      OR f.Keyword2 = keywords.Keyword3
      OR f.Keyword3 = keywords.Keyword1
      OR f.Keyword3 = keywords.Keyword2
      OR f.Keyword3 = keywords.Keyword3) UNION ALL
    (SELECT f.Name, f.Price, f.RestaurantID, 2 AS points
    FROM food_dishes f, (SELECT f.Name, f.RestaurantID
    FROM users u, food_dishes f
    WHERE u.UserID  = '$User_ID'
    AND u.Favorite_Dish = f.DishID) AS rID
    WHERE rID.RestaurantID = f.RestaurantID) UNION ALL
  (SELECT f.Name, f.Price, f.RestaurantID, f.Popularity AS points
    FROM food_dishes f
    ORDER BY f.Popularity DESC)) as results
  GROUP BY results.Name
  ORDER BY count DESC
  LIMIT 10) AS ranking
WHERE r.RestaurantID = ranking.RestaurantID
ORDER BY (ranking.count + (r.Overall_Rating) / 5) DESC;";

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




if($_POST["add"]) {

  $User_ID = $_SESSION['login_id'];
  $dish =  mysqli_real_escape_string($db,$_POST['dish']);;
  $day =  mysqli_real_escape_string($db,$_POST['day']);;


  $sql2 = "SELECT ScheduleID FROM weekly_schedule WHERE ScheduleID = '$User_ID' ";
  $result = mysqli_query($db, $sql2);

  $count = mysqli_num_rows($result);

  echo $count;

  if($count == 1) {


    if($day == 'Mon_Dish') {
      $sql11 = "UPDATE weekly_schedule SET Mon_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql11);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Tue_Dish') {
      $sql12 = "UPDATE weekly_schedule SET Tue_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql12);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Wed_Dish') {
      $sql13 = "UPDATE weekly_schedule SET Wed_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql13);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Thu_Dish') {
      $sql14 = "UPDATE weekly_schedule SET Thu_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql14);
      header("Location:weekly_schedule.php");
    }

    if($day == 'Fri_Dish') {
      $sql15 = "UPDATE weekly_schedule SET Fri_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql15);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Sat_Dish') {
      $sql16 = "UPDATE weekly_schedule SET Sat_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql16);
      header("Location:weekly_schedule.php");
    }

    if($day == 'Sun_Dish') {
      $sql17 = "UPDATE weekly_schedule SET Sun_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql17);
      header("Location:weekly_schedule.php");
    }
    
  }else {
      mysqli_query($db, "INSERT INTO weekly_schedule (ScheduleID) VALUES('$User_ID') ");


          if($day == 'Mon_Dish') {
      $sql11 = "UPDATE weekly_schedule SET Mon_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql11);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Tue_Dish') {
      $sql12 = "UPDATE weekly_schedule SET Tue_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql12);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Wed_Dish') {
      $sql13 = "UPDATE weekly_schedule SET Wed_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql13);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Thu_Dish') {
      $sql14 = "UPDATE weekly_schedule SET Thu_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql14);
      header("Location:weekly_schedule.php");
    }

    if($day == 'Fri_Dish') {
      $sql15 = "UPDATE weekly_schedule SET Fri_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql15);
      header("Location:weekly_schedule.php");
    }


    if($day == 'Sat_Dish') {
      $sql16 = "UPDATE weekly_schedule SET Sat_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql16);
      header("Location:weekly_schedule.php");
    }

    if($day == 'Sun_Dish') {
      $sql17 = "UPDATE weekly_schedule SET Sun_Dish = (select DishID from food_dishes where Name = '$dish') WHERE ScheduleID = '$User_ID' ";
      mysqli_query($db, $sql17);
      header("Location:weekly_schedule.php");
    }


      header("Location:weekly_schedule.php");
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
          <legend>What do you want to eat?</legend>
          <div class="inner-form">
            <div class="input-field">
              <!--COMMENT: This is the search botton. Click it will do the search
              (run sql queries display result in the table below)-->
              <!-- <button class="btn-search" type="submit" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </button> -->
              <input class="btn-search" type="submit" name="search" value="Search">
              <input id="search" type="text" name = "keyword" placeholder=""/>
            </div>
          </div>
        </fieldset>
        </form>
    </div>
  
  



    <!-- COMMENT: The following is the table to display the search result. -->

  <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
    <div class="limiter">
      <div class="container-table100">
        <div class="wrap-table100">
          <div style = “font-size:11px; color:#fff; margin-top:10px”><?php echo $error_message1; ?></div>

             <select class="select-css-day" name="day">
              <option value="Mon_Dish" selected="selected">MONDAY</option>
              <option value="Tue_Dish">TUESDAY</option>
              <option value="Wed_Dish">WEDNESDAY</option>
              <option value="Thu_Dish">THURSDAY</option>
              <option value="Fri_Dish">FRIDAY</option>
              <option value="Sat_Dish">SATURDAY</option>
              <option value="Sun_Dish">SUNDAY</option>
            </select>

          </br>
          </br>


            <select class="select-css-dish" name="dish" size=10>
              <option value= "<?php echo $array_result[0]['Dish_Name']; ?>"><?php echo $array_result[0]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[0]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[0]['Price'] ?></option> 

              <option value= "<?php echo $array_result[1]['Dish_Name']; ?>"><?php echo $array_result[1]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[1]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[1]['Price'] ?></option> 

              <option value= "<?php echo $array_result[2]['Dish_Name']; ?>"><?php echo $array_result[2]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[2]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[2]['Price'] ?></option> 

              <option value= "<?php echo $array_result[3]['Dish_Name']; ?>"><?php echo $array_result[3]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[3]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[3]['Price'] ?></option> 

              <option value= "<?php echo $array_result[4]['Dish_Name']; ?>"><?php echo $array_result[4]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[4]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[4]['Price'] ?></option> 

              <option value= "<?php echo $array_result[5]['Dish_Name']; ?>"><?php echo $array_result[5]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[5]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[5]['Price'] ?></option> 

              <option value= "<?php echo $array_result[6]['Dish_Name']; ?>"><?php echo $array_result[6]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[6]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[6]['Price'] ?></option> 

              <option value= "<?php echo $array_result[7]['Dish_Name']; ?>"><?php echo $array_result[7]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[7]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[7]['Price'] ?></option> 

              <option value= "<?php echo $array_result[8]['Dish_Name']; ?>"><?php echo $array_result[8]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[8]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[8]['Price'] ?></option> 

              <option value= "<?php echo $array_result[9]['Dish_Name']; ?>"><?php echo $array_result[9]['Dish_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $array_result[9]['Restaurant_Name'] . "&nbsp;&nbsp;&nbsp;&nbsp;$" . $array_result[9]['Price'] ?></option>
            </select>

            <div class="container-login100-form-btn m-t-20">
              <input class="container-login100-form-btn" type="submit" name="add" style="background-color: #fff" value="ADD">
            </div>

        </div>
      </div>
    </div>
  </form>

  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>


