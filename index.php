<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $sql = "SELECT UserID, Name, password FROM users WHERE Name = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
         $sql = "SELECT UserID FROM users WHERE Name = '$myusername'";
         $result = mysqli_query($db,$sql);
         $_SESSION['login_id'] = $result;


         header("Location:weekly_schedule.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>


<html>
<head>
   <title>Login</title>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
   <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
   <link rel="stylesheet" type="text/css" href="css/util.css">
   <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->

</head>
<body>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">

   <div class="limiter">
      <div class="container-login100">
         <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
            <form class="login100-form validate-form">
               <span class="login100-form-title p-b-33">
                  Account Login
               </span>



               <!--COMMENT: Input box to enter userid and password. We want to search for this user's weekly schedule-->
                  <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                     <input class="input100" type="text" name="username" placeholder="Username">
                     <span class="focus-input100-1"></span>
                     <span class="focus-input100-2"></span>
                  </div>

                  <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                     <input class="input100" type="password" name="password" placeholder="Password">
                     <span class="focus-input100-1"></span>
                     <span class="focus-input100-2"></span>
                  </div>



               <!--COMMENT: Sign-in button. Click it will link to the table page of the specific user.-->
                  <div class="container-login100-form-btn m-t-20">
                  <input class="login100-form-btn" type="submit" value="SIGN IN">
                  </div>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>




               <div class="text-center">
                  <span class="txt1">
                     Create an account?
                  </span>

                  <a href="register.php" class="txt2 hov1">
                     Sign up
                  </a>
               </div>
            </form>
         </div>
      </div>
   </div>
   </form>
</body>

</html>
<!-- <html>

   <head>
      <title>Login Page</title>

      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>

   </head>

   <body bgcolor = "#FFFFFF">

      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

            <div style = "margin:30px">

               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>

               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>

            </div>

         </div>

      </div>

   </body>
</html> -->
