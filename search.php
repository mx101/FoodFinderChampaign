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

$sql = "SELECT ranking.Name AS Dish_Name, r.Name AS Restaurant_Name, (ranking.count + (r.Overall_Rating) / 5) AS rank
FROM restaurant r, (SELECT results.Name, SUM(results.points) AS count, results.RestaurantID
  FROM ((SELECT f.Name, f.RestaurantID, 5 AS points
    FROM food_dishes f
    WHERE f.Keyword1 = '$keyword'
    OR f.Keyword2 = '$keyword'
    OR f.Keyword3 = '$keyword') UNION ALL
  (SELECT f.Name, f.RestaurantID, 5
    FROM food_dishes f
    WHERE f.Name LIKE CONCAT('%', '$keyword', '%')) UNION ALL
    (SELECT f.Name, f.RestaurantID, 3
    FROM food_dishes f, restaurant r
    WHERE r.RestaurantID = f.RestaurantID
    AND r.Name LIKE CONCAT('%', '$keyword', '%')) UNION ALL
  (SELECT f.Name, f.RestaurantID, 3
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
    (SELECT f.Name, f.RestaurantID, 2
    FROM food_dishes f, (SELECT f.Name, f.RestaurantID
    FROM users u, food_dishes f
    WHERE u.UserID  = '$User_ID'
    AND u.Favorite_Dish = f.DishID) AS rID
    WHERE rID.RestaurantID = f.RestaurantID) UNION ALL
  (SELECT f.Name, f.RestaurantID, 1
    FROM food_dishes f
    ORDER BY f.Popularity DESC)) as results
  GROUP BY results.Name
  ORDER BY count DESC
  LIMIT 10) AS ranking
WHERE r.RestaurantID = ranking.RestaurantID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_array()) {
        $array_result[] = $row;
    }
} else {
    echo "0 results";
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
              <button class="btn-search" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </button>
              <input id="search" type="text" name = "keyword" placeholder="" value="sushi, italian, pizza..." />
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </form>



    <!-- COMMENT: The following is the table to display the search result. -->

    <div class="limiter">
      <div class="container-table100">
        <div class="wrap-table100">

          <div class="table100 ver5 m-b-110">
            <table data-vertable="ver5">
              <tbody>
                <!--COMMENT: Row 1 of the result. Click it should insert the dish into
                Weekly Schedule Table at the backend. Also link back to weekly_schedule.html-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[1]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[1]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[1]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 2. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[2]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[2]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[2]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 3. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[3]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[3]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[3]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 4. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[4]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[4]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[4]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 5. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[5]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[5]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[5]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 6. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[6]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[6]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[6]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 7. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[7]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[7]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[7]['rank'] ?></td>
                </tr>

                 <!--COMMENT: Row 8. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[8]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[8]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[8]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 9. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[9]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[9]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[9]['rank'] ?></td>
                </tr>

                <!--COMMENT: Row 2. Same as row 1.-->
                <tr class="row100">
                  <td class="column100" data-column="column2"> <?php echo $array_result[10]['Dish_Name'] ?> </td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[10]['Restaurant_Name'] ?></td>
                  <td class="column100" data-column="column2"> <?php echo $array_result[10]['rank'] ?></td>
                </tr>
                


              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>


