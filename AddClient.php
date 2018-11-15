<?php
  require ('db.php');

//echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

if ($conn)
  //echo "connected"; 

//echo ini_get('display_errors');

  if (isset($_POST['submit'])) 
  {
      session_start();
      $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
      $Lname = mysqli_real_escape_string($conn, $_POST['Lname']);
      $nationalID = mysqli_real_escape_string($conn, $_POST['nationalID']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $phone= mysqli_real_escape_string($conn, $_POST['phone']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $currency = mysqli_real_escape_string($conn, $_POST['currency']);
      
      $userType = $_SESSION['userType'];

      header("location: OpenAccount.php");

      $sql1 = "INSERT INTO client (nationalID, email, phone, address,Fname, Lname) VALUES ('$nationalID', '$email', '$phone', '$address', '$Fname', '$Lname')";

      $query = "SELECT clientID FROM client WHERE phone = '".$phone."'";
      $result = mysqli_query($conn, $query);
      $newClient = mysqli_fetch_assoc($result);
      $wantedID = $newClient [ 'clientID'];
      
      $sql2 = "INSERT INTO bankAccount (accountType, currency_code, accClientID) VALUES ('$type', '$currency', $wantedID)";
      
      if(mysqli_query($conn, $sql1))
      {
        //echo "Records inserted into client successfully.";
      } 
      else
      {
        //echo "ERROR: Could not able to execute " . mysqli_error($conn);
      }

      if(mysqli_query($conn, $sql2))
      {
        //echo "Records inserted into bank account successfully.";
      } 
      else
      {
        //echo "ERROR: Could not able to execute" . mysqli_error($conn);
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
        height: 120%
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
          <label for="exampleInputFistName1">First Name </b></label> 
          <input name="Fname" type="name" class="form-control" id="First Name" placeholder="First Name">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputLastName1">Last Name</label> 
          <input name="Lname" type="name" class="form-control" id="Last Name" placeholder="Last Name">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputNationalID1">National ID</label>
          <input name="nationalID" type="nationalID" class="form-control" id="exampleInputNationalID1" placeholder="National ID">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputEmail">Email</label>
          <input name="email" type="Email" class="form-control" id="exampleInputEmail" placeholder="Email">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputPhone">Phone</label>
          <input name = "phone" type="Phone" class="form-control" id="exampleInputPhone" placeholder="Phone">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputAddress">Address</label>
          <input name = "address" type="Address" class="form-control" id="exampleInputAddress" placeholder="Address">
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