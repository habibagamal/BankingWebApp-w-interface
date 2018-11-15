<?php
  require ('db.php');
session_start();
//echo ini_get('display_errors');

if (!ini_get('display_errors')) 
{
    ini_set('display_errors', '1');
}

$username = $_SESSION['username'];
//echo $username; 
$sql = "SELECT * FROM onlineAccount WHERE username= '".$username."'";
$result = mysqli_query($conn, $sql);
$client = mysqli_fetch_assoc($result);

//echo $client['userType'];

if ($conn)
{
  //echo "connected"; 
}
else
{

}
//echo ini_get('display_errors');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div class="pos-f-t">
      <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class = "navbar-brand" href ="#"><img src = "logo.jpg" width="70" height = "70"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
      </nav>
      <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
        <button type="button" class="btn btn-danger">HOME</button>
        </div>
      </div>
    </div>

    <!-- Image Slider -->
    <div id ="slides" class ="carousel slide" data_ride="carousel">
    	<ul class = "carousel-indicators">
    		<li data-target="#slides" data-slide-to="0" class="active"></li>
    		<li data-target="#slides" data-slide-to="1"></li>
    	</ul>
    	<div class = "carousel-inner">
    		<div class = "carousel-item active">
    			<img class="d-block w-100 h-100" src ="background0.jpg" height="450">
    			<div class ="carousel-caption">
    				<button type="button" class= "btn btn-outline-light btn-lg"> <a href="signIn.php"style="color:white">SIGN IN </button></a>
    				<button type="button" class= "btn btn-primary btn-lg"><a href="signUp_client.php" style="color:white">SIGN UP </button></a>
    			</div>
    		</div>
    		<div class = "carousel-item">
    			<img class="d-block w-100 h-100" src ="background1.jpg">
    			 <div class ="carousel-caption">
    				<button type="button" class= "btn btn-outline-light btn-lg"><a style="color:white"> SIGN IN </button> </a>
    				<button type="button" class= "btn btn-primary btn-lg"><a href="signIn.php" href="signUp_client.php" style="color:white"> SIGN UP </button></a>
    			</div>
    		</div>
    	</div>
    </div>


    <!-- Welcome Section -->
    <div class ="container-fluid padding">
    <div class = "row welcome text-center">
    	<div class ="col-12">
    		<h1 class="display-4">Easier Than Ever</h1>
    		<h6> Sign up for ONLINE BANKING.</h6>
    		<h5> Save money. Save time. Access anywhere. </h5>
    	</div>
    </div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

