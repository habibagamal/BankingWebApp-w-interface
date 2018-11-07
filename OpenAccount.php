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
      header ("location:Accounts.php");
      $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);
      $_SESSION['clientID'] = $clientID;
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $currency = mysqli_real_escape_string($conn, $_POST['currency']);
      $sql = "INSERT INTO bankAccount (accClientID, currency_code, accountType) VALUES ($clientID, $currency, '$type')";
      if(mysqli_query($conn, $sql))
      {
        echo "account added";
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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
      <form method="POST" action="#">
        <div class="form-group" style="color:white">
          <label for="exampleInputClientID">Client ID</label>
          <input name="clientID" type="number" class="form-control" id="exampleInputClientID" placeholder="Enter Client  ID">
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Type</label>
          <select name = "type" class="form-control" id="exampleFormControlSelect1">
            <option value = "1">Savings</option>
            <option value = "0">Current</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Type</label>
          <select name = "currency" class="form-control" id="exampleFormControlSelect1">
            <option value = "1">USD</option>
            <option value = "2">EGP</option>
            <option value = "3">QR</option>
          </select>
        </div>
        <button name = "submit" type="submit" class="btn btn-primary">Create New</button>
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