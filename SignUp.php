<?php
  require ('db.php');
session_start();
echo ini_get('display_errors');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

$userType = $_SESSION['userType'];
echo $userType;

if ($conn)
  echo "connected"; 

//echo ini_get('display_errors');

  if (isset($_POST['submit'])) 
  {
      session_start();
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
      $Lname = mysqli_real_escape_string($conn, $_POST['Lname']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      $nationalID = mysqli_real_escape_string($conn, $_POST['nationalID']);
      $clientID = mysqli_real_escape_string($conn, $_POST['clientID']);
      $accountNUM = mysqli_real_escape_string($conn, $_POST['accountNUM']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $password_status = 0;
      $account_status  = 0;

      $query = "SELECT username, userType, user_password FROM OnlineAccount WHERE username = '".$username."'";
      $result_query = mysqli_query($conn, $query);
      $user = mysqli_fetch_assoc($result_query);

      // if ($userType == '10')
      //   header("location: Administrator.php");
      // else
      //   header("location: Home.php");

      $hashed = password_hash ($password, PASSWORD_DEFAULT, ['COST => 10']);

      
      if ($user['username'] == $username)
      {
        $check = password_verify($password, $user['user_password']);

        if ($check)
        {
          if ($user['userType'] == '01' && $type == '00') 
          {
              $accountNUMINT = (int) $accountNUM;
              $clientIDINT  = (int) $clientID;

            $sql = "UPDATE OnlineAccount SET clientID = '".$clientIDINT."', nationalID = '".$nationalID."', Fname = '".$Fname."', Lname = '".$Lname."' , AccountNum = '".$accountNUMINT."',userType = '11', account_status = '1' WHERE username = '".$username."'";
          }
          else if ($user['userType'] == '00' && $type == '01')
          {
            $sql = "UPDATE OnlineAccount SET userType = '11' WHERE username = '".$username."'";
          }
        }
      }
      else if ($type == '00' && $userType != '10')
      {
        $accountNUMINT = (int) $accountNUM;
        $clientIDINT  = (int) $clientID;
        $sql = "INSERT INTO OnlineAccount (username, user_password, account_status, password_status, clientID, nationalID, Fname, Lname, AccountNum, userType) VALUES ('$username', '$hashed', '1', '$password_status', $clientIDINT, '$nationalID', '$Fname', '$Lname', $accountNUMINT, '$type')";
        echo "2";
      }
      else if ($type == '01')
      {
        $sql = "INSERT INTO OnlineAccount (username, user_password, account_status, password_status, Fname, Lname, userType) VALUES ('$username', '$hashed', '$account_status', '$password_status', '$Fname', '$Lname', '$type')";
        echo "3";
      }
      else if ($type == '10')
      {
        $sql = "INSERT INTO OnlineAccount (username, user_password, account_status, password_status, Fname, Lname, userType) VALUES ('$username', '$hashed', '$account_status', '$password_status', '$Fname', '$Lname', '$type')";
        echo "4";
      }
      else if ($type == '11')
      {
        $accountNUMINT = (int) $accountNUM;
        $clientIDINT  = (int) $clientID;
        $sql = "INSERT INTO OnlineAccount (username, user_password, account_status, password_status, clientID, nationalID, Fname, Lname, AccountNum, userType) VALUES ('$username', '$hashed', '1', '$password_status', $clientIDINT, '$nationalID', '$Fname', '$Lname', $accountNUMINT, '$type')";
        echo "5";
      }
      
      if(mysqli_query($conn, $sql))
      {
        echo "Records inserted successfully.";
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
        <<button type="button" class="btn btn-warning" ><a href="home.php" style="color:white">LOGOUT</button></a>
        </div>
    </div>
  </div>

    <!--Form-->
    <br>
  <div class="container d-flex justify-content-center align-items-center">
    <div class ="card align-items-center text-center" style="width:20rem; background-color:rgb(0, 0, 0);opacity:0.7;">
      <form method = "POST" action="#">
        <div class="form-group" style="color:white">
          <label for="exampleInputFistName1">First Name </b></label> 
          <input name="Fname" type="Fname" class="form-control" id="First Name" placeholder="First Name">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputLastName1">Last Name</label> 
          <input name="Lname" type="Lname" class="form-control" id="Last Name" placeholder="Last Name">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputEmail1">Username</label>
          <input name="username" type="username" class="form-control" id="exampleInputUsername1" placeholder="Enter username">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">Password</label>
          <input name = "password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">National ID</label>
          <input name = "nationalID" type="nationalID" class="form-control" id="exampleInputNationalID1" placeholder="National ID">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">Account Number</label>
          <input name = "accountNUM" type="Number" class="form-control" id="exampleInputAccountNum1" placeholder="Account Number">
        </div>
        <div class="form-group" style="color:white">
          <label for="exampleInputPassword1">Client ID</label>
          <input name = "clientID" type="Number" class="form-control" id="exampleInputClientID" placeholder="Client ID">
        </div>
        <div class="form-group">
          <label for="exampleFormControlSelect1">Type</label>
          <select name="type" class="form-control" id="exampleFormControlSelect1">
              <option value = "00">Client</option>
              <option value = "01">Teller</option>
              <option value = "10">Administrator</option>
              <option value = "11">Teller and Client</option>
          </select>
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