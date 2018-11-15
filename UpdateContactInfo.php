<?php
require ('db.php');

//echo ini_get('display_errors');

if (!ini_get('display_errors')) 
{
    ini_set('display_errors', '1');
}
  $message = "";
  $color = "green"; 
if ($conn)
  //echo "connected"; 

//echo ini_get('display_errors');

  if (isset($_POST['submit1'])) 
  {
      session_start();

      $currUser = $_SESSION ['username'];
      $query = "SELECT * FROM onlineAccount WHERE username = '".$currUser."'";
      $result = mysqli_query($conn, $query);
      $account = mysqli_fetch_assoc($result);

      $clientID = $_SESSION ['clientID'];
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password1 = mysqli_real_escape_string($conn, $_POST['password1']);

      //echo $currUser;

      $check = password_verify($password1, $account['user_password']);
      
      if ($check)
      {
        $sql = "UPDATE client SET email = '".$email."' WHERE clientID = '".$clientID."'";

        if(mysqli_query($conn, $sql))
        {
          $message = "Email Changed";
          //echo "email changed";
        } 
        else
        {

        $color = "red";
        $message = "Error connecting to database";
          //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
      }
      else 
      {

        $color = "red";
        $message = "Incorrect Password";
      }
 
    }
  if (isset($_POST['submit2'])) 
  {
      session_start();

      $currUser2= $_SESSION ['username'];
      $query2 = "SELECT * FROM onlineAccount WHERE username = '".$currUser2."'";
      $result2 = mysqli_query($conn, $query2);
      $account2 = mysqli_fetch_assoc($result2);

      $clientID2 = $_SESSION ['clientID'];
      
      $phone = mysqli_real_escape_string($conn, $_POST['phone']);
      $password2 = mysqli_real_escape_string($conn, $_POST['password2']);

      //echo $currUser2;

      $check = password_verify($password2, $account2['user_password']);
      
      if ($check)
      {
        $sql = "UPDATE client SET phone = '".$phone."' WHERE clientID = '".$clientID2."'";

        if(mysqli_query($conn, $sql))
        {
          $message = "Phone Changed";
          //echo "phone changed";
        } 
        else
        {
                  $color = "red";
        $message = "Error connecting to database";
          //echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
      }
      else
      {

        $color = "red";
        $message = "Incorrect Password";
      }
  }
?>
<!doctype html>
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
      <br>
      <br>
      <br>
        <div >
          <p align="center" style="color: <?php echo $color?>;"> <?php echo $message ?></p>
        </div>
      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Update Email</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <form method = "POST" action = "#">
            <input name = "email" type="Client's Email" class="form-control" id="exampleDropdownEmail" placeholder="New email">
            <br>
            <input name = "password1" type="password" class="form-control" id="exampleDropdownPassword" placeholder="Enter Password">
            <br>
            <button name = "submit1" type="enter" class="btn btn-dark" >Submit</button>
          </form>
        </div>
      </div>

      <br>
      <br>
      <br>

      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Update Phone Number</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu ">
          <form method = "POST" action = "#">
            <input name = "phone" type="Client's Phone Number" class="form-control" id="exampleDropdownPhone" placeholder="New PhoneNumber">
            <input name="password2" type="Client's Password" class="form-control" id="exampleDropdownPassword" placeholder="Enter Password">
            <button name="submit2" type="enter" class="btn btn-dark" >Submit</button>
          </form>
        </div>
      </div>

      <br>
      <br>
      <br>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>