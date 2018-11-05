<?php
require ('db.php');

echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

if ($conn)
  echo "connected"; 

echo ini_get('display_errors');

  if (isset($_POST['submit'])) 
  {
      session_start();

      $currUser = $_SESSION ['username'];
      $userType = $_SESSION ['userType'];
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
      $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

      echo $currUser;

      if ($password1 == $password2)
      {

        $hashed = password_hash ($password1, PASSWORD_DEFAULT, ['COST => 10']);
        echo $hashed;
        if ($userType == '10')
        {
            header("location:Administrator.php");
            $sql = "UPDATE OnlineAccount SET user_password ='".$hashed."', password_status = '1' WHERE username = '".$username."' AND userType != '00'";
            if(mysqli_query($conn, $sql))
            {
              echo "password changed";
            } 
            else
            {
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
        }
        else
          if ($currUser == $username)
          {
            if ($userType == '00')
            {
              header("location:client.php");
              echo "password changed";
            }
            if ($userType == '01')
            {
              header("location:teller.php");
              echo "password changed";
            }
            if ($userType == '10')
            {
              header("location:administrator.php");
              echo "password changed";
            }
            $sql = "UPDATE OnlineAccount SET user_password ='".$hashed."', password_status = '0' WHERE username = '".$username."'";
            if(mysqli_query($conn, $sql))
            {
              echo "password changed";
            } 
            else
            {
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }
          }
      }
 
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <style>
      html,body 
      {
        background-image: url("bank1.jpg");
        height: 400%;
    /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 100%
      }
    </style>
   </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <!-- NAVIGATION -->
   <div class="pos-f-t">
      <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class = "navbar-brand" href ="#"><img src = "logo.jpg" width="70" height = "70"></a>

            <button class="btn btn-secondary" onclick="goBack()">Go Back</button>
            <script>
              function goBack() 
              {
              window.history.back();
              }
            </script>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
      </nav>
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
        <button type="button" class="btn btn-success" ><a href="home.php" style="color:white">HOME</button></a>
        <button type="button" class="btn btn-warning" ><a href="home.php" style="color:white">LOGOUT</button></a>
        </div>
    </div>
  </div>

    <!--Form-->
    <br>
    <br>
    <br>
  <div class="container d-flex justify-content-center align-items-center">
    <div class ="card align-items-center text-center" style="width:20rem;background-color:rgb(0, 0, 0);opacity:0.7;">
      <form method ="POST" action = "#">
        <div class="form-group" style="color:white">
          <label for="exampleInputEmail1">Username</label>
          <input name="username" type="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username ">
        </div>
        <br>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">New Password</label>
          <input name="password1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <br>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">Confirm New Password</label>
          <input name ="password2" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button name="submit" type="submit" class="btn btn-primary">Submit Change</button>
      </form>
    </div>
  </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>