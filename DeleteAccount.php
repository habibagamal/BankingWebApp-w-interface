<?php
  require ('db.php');
session_start();
$AdminUsername = $_SESSION['username'];
//echo $AdminUsername;

//echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

if ($conn)
  //echo "connected"; 

//echo ini_get('display_errors');

  $message = "";
  $color = "green"; 

  if (isset($_POST['submit'])) 
  {
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      //echo $username;

      $sql = "SELECT * FROM OnlineAccount WHERE username = '".$AdminUsername."'";

      if(mysqli_query($conn, $sql))
      {
        //echo "Fetched";
      } 
      else
      { 
        $color = "red";
        $message = "Can't Connect to database";
        //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      }

      $result = mysqli_query($conn, $sql);

      $client = mysqli_fetch_array($result);

      $check = password_verify($password, $client['user_password']);

      if ($check)
      {
         //$sql2 = "SET FOREIGN_KEY_CHECKS = 0;"
        // if(mysqli_query($conn, $sql2))
        // {
        //   echo "Foreign Key Check cancelled";
        // } 
        // else
        // {
        //   echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        // }

        $sql1 = "DELETE FROM OnlineAccount WHERE username = '".$username."' AND userType != '00' ";



        if(mysqli_query($conn, $sql1))
        {
          $affected = (int)mysqli_affected_rows($conn);
          if($affected > 0){ $message = "Account Deleted"; }
          else {$message = "Account Not Found!"; $color = "red";}
        
        } 
        else
        {
          $message = "COULD NOT EXECUTE SQL";
          //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

        // $sql3 = ;//"SET FOREIGN_KEY_CHECKS=1;"
        
        // if(mysqli_query($conn, $sql3))
        // {
        //   echo "Foreign Key Check";
        // } 
        // else
        // {
        //   echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        // }
      }else {

        $color = "red";
        $message = "Incorrect Password";

      }
 
  }
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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

    <!--Cards-->

    <br>
    <br>
    <br>
  <div class="container d-flex justify-content-center align-items-center">
    <div class ="card align-items-center text-center" style="width:20rem;background-color:rgb(0, 0, 0);opacity:0.7;">
      <form method = "POST" action = "#">
        <div >
          <p style="color: <?php echo $color?>;"> <?php echo $message ?></p>
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputEmail1">Enter Username</label>
          <input name = "username" type="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
        </div>
        <br>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">Enter Password</label>
          <input name = "password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <br>
        <button name = "submit" type="submit" class="btn btn-primary">Delete Account</button>
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