 <?php
  require ('db.php');

  session_start();

  if(isset($_GET['id']) && $_GET['id'] !== '')
  {
    $clientUsername = $_GET['id'];
    echo $clientUsername;
  } 
  else 
  {
    echo "failed";
  }
  
  echo ini_get('display_errors');

  if (!ini_get('display_errors')) 
  {
    ini_set('display_errors', '1');
  }

  if ($conn)
    echo "connected"; 

  echo ini_get('display_errors');

  $sql = "SELECT * FROM OnlineAccount WHERE username = '".$clientUsername."'";

  $result = mysqli_query($conn, $sql);

  $application = mysqli_fetch_array($result);
  $clientID= $application['clientID'];
  $userType = $application['userType'];
  echo " userType = ";
  echo $userType; 

  $query = "SELECT * FROM client WHERE clientID = '".$clientID."'";
  $result1 = mysqli_query($conn, $query);

  $real = mysqli_fetch_array($result1);


  $query2 = "SELECT * FROM bankAccount WHERE accClientID = '".$clientID."'";
  $result2 = mysqli_query($conn, $query2);

  $real2 = mysqli_fetch_array($result2);

  if (isset($_POST['submit'])) 
  {
      header ("location:Administrator.php");
      $status = mysqli_real_escape_string($conn, $_POST['status']);
      echo $status;
      
      if ($status == "2")
      {
        if ($userType == '11')
        {
          $sql1 = "UPDATE OnlineAccount SET account_status='0', userType = '01' WHERE username = '".$clientUsername."'";
        }
        else $sql1 = "DELETE FROM OnlineAccount WHERE username = '".$clientUsername."'";
        if(mysqli_query($conn, $sql1))
        {
          echo "Application declined";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
      }
      else if ($status == "1")
      {
        $sql2 = "UPDATE OnlineAccount SET account_status = '0' WHERE username = '".$clientUsername."'";
        if(mysqli_query($conn, $sql2))
        {
          echo "Application approved";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }

      }
      else 
      {

      }
      exit();
  }
  else 
  {
      echo "post not working";
  }

  if(mysqli_query($conn, $sql))
  {
    echo "Fetched";
  } 
  else
  {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
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

  <!-- Table -->
<table class="table">
    <thead>
        <tr>
            <th>Source</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Number</th>
            <th>Client ID</th>
            <th>National ID</th>
            <th>Username</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Application</td>
            <td><?php echo $application['Fname']; ?></td>
            <td><?php echo $application['Lname']; ?></td>
            <td><?php echo $application['AccountNum']; ?></td>
            <td><?php echo $application['clientID']; ?></td>
            <td><?php echo $application['nationalID']; ?></td>
            <td><?php echo $application['username']; ?></td>
        </tr>  

        <tr>
            <td>Account</td>
            <td><?php echo $real['Fname']; ?></td>
            <td><?php echo $real['Lname']; ?></td>
            <td><?php echo $real2['accountNum']; ?></td>
            <td><?php echo $real['clientID']; ?></td>
            <td><?php echo $real['nationalID']; ?></td>
            <td> </td>
        </tr>     
    </tbody>
  </table>
   <div class="container d-flex justify-content-center align-items-center">
    <div class ="card align-items-center text-center" style="width:20rem;background-color:rgb(0, 0, 0);opacity:0.7;">
      <form method="POST" action="#">
        <div class="form-group">
          <label for="exampleFormControlSelect1" style="color:white">Status</label>
          <select name = "status" class="form-control" id="exampleFormControlSelect1" >
            <option value="0">Pending</option>
            <option value="1">Approved</option>
            <option value="2">Declined</option>
          </select>
        </div>
        <button name="submit" type="submit" class="btn btn-danger"> Change</button>
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
