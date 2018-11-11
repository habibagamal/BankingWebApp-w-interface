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
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);

      $sql = "SELECT * FROM OnlineAccount WHERE username = '".$username."'";

      if(mysqli_query($conn, $sql))
      {
        echo "Fetched";
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      }

      $result = mysqli_query($conn, $sql);

      $client = mysqli_fetch_array($result);

      $check = password_verify($password, $client['user_password']);

      if ($check)
      {
        if ($client['userType'] == '00' && $client['account_status'] == '0')
        {
          if ($client['password_status'] == '1')
            header ("location:ChangePassword.php");
          else
          header ("location:client.php");
          $_SESSION['username'] = $client['username'];
          $_SESSION['userType'] = $client['userType'];
          $_SESSION['clientID'] = $client['clientID'];
          exit();
        }
        else if ($client['userType'] == '01')
        {
          if ($client['password_status'] == '1')
            header ("location:ChangePassword.php");
          else
            header ("location:Teller.php");
          $_SESSION['username'] = $client['username'];
          $_SESSION['userType'] = $client['userType'];
          exit();
        }
        else if ($client['userType'] == '10')
        {
          if ($client['password_status'] == '1')
            header ("location:ChangePassword.php");
          else
          header ("location:Administrator.php");
          $_SESSION['username'] = $client['username'];
          $_SESSION['userType'] = $client['userType'];
          exit();
        }
        
        else if ($client['userType'] == '11')
        {
          if ($client['password_status'] == '1')
            header ("location:ChangePassword.php"); 
          else if ($client['account_status'] == '1')
            header ("location:Teller.php");
          else 
            header ("location:Teller_Client1.php");
          
          $_SESSION['username'] = $client['username'];
          $_SESSION['userType'] = $client['userType'];
          $_SESSION['clientID'] = $client['clientID'];

          exit();
        }
      }
    }
    if (isset($_POST['forget']))
    {

      $username = mysqli_real_escape_string($conn, $_POST['username']);

      if ($username != NULL)
      {
        $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@!#$%^&*";
        $new = substr(str_shuffle($string),0,8);
        echo " New Password is: ";
        echo $new; 
        
        $hashed = password_hash ($new, PASSWORD_DEFAULT, ['COST => 10']);
        $query  = "UPDATE OnlineAccount SET user_password = '".$hashed."', password_status = '1' WHERE username = '".$username."'";

        if(mysqli_query($conn, $query))
        {
          echo "Password changed";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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
  <div class="container d-flex justify-content-center align-items-center">
    <div class ="card align-items-center text-center" style="width:20rem; background-color:rgb(0, 0, 0);opacity:0.7;">
      <form method = "POST" action = "#">
        <div class="form-group" style="color:white">
          <label for="exampleInputFistName1">Username </b></label> 
          <input name = "username" type="name" class="form-control" id="First Name" placeholder="First Name">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputLastName1">Password</label> 
          <input name = "password" type="password" class="form-control" id = "password" placeholder="password">
        </div>
        <br>
        <button name = "submit" type="submit" class="btn btn-primary">Enter</button>
        <button name = "forget" type="submit" class="btn btn-danger">Forget Password</button>
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