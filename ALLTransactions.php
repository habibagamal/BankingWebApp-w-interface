<?php
  require ('db.php');

  echo ini_get('display_errors');

  if (!ini_get('display_errors')) 
  {
    ini_set('display_errors', '1');
  }

  if ($conn)
    echo "connected";

  echo ini_get('display_errors');
  
  $sql = "SELECT * FROM acc_transaction";

  $result = mysqli_query($conn, $sql);

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
  <thead class="thead-dark">
    <tr>
      <th scope="col">Transation ID</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
      <th scope="col">Time</th>
      <th scope="col">Teller</th>
      <th scope="col">Type</th>
      <th scope="col">Recepient</th>
    </tr>
  </thead>
  <tbody>
      <?php
      while ($transaction = mysqli_fetch_assoc($result))
      {
        ?>
      <tr>
        <td><?php echo $transaction['transaction_id']; ?></td>
        <td><?php echo $transaction['amount']; ?></td>
        <td><?php echo $transaction['transaction_date']; ?></td>
        <td><?php echo $transaction['transaction_time']; ?></td>
        <td><?php echo $transaction['teller']; ?></td>
        <td><?php echo $transaction['transaction_type']; ?></td>
        <td><?php echo $transaction['transfer_recepient']; ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
