<?php
  require ('db.php');

  session_start();

  if(isset($_GET['id']) && $_GET['id'] !== '')
  {
    $accountNum = $_GET['id'];
    $_SESSION['accountNum'] = $accountNum;
    echo $accountNum;
  } 
  else 
  {
    echo "failed";
  }

  $tellerUsername = $_SESSION['username'];
  echo $tellerUsername;

  $userType = $_SESSION['userType'];
  echo $userType;

  echo ini_get('display_errors');

  if (!ini_get('display_errors')) 
  {
    ini_set('display_errors', '1');
  }

  if ($conn)
    echo "connected";

  echo ini_get('display_errors');

  $sql = "SELECT * FROM bankAccount WHERE accountNum = '".$accountNum."'";
  $result = mysqli_query($conn, $sql);
  $account = mysqli_fetch_assoc($result);

  // $sqlNum = "SELECT phone FROM client WHERE clientID = ".$account['accClientID']."'";
  // $resultNum = mysqli_query($conn, $sqlNum);
  // $phone = mysqli_fetch_assoc($resultNum);

echo $tellerUsername;
echo $userType;
  if (isset($_POST['transfer'])) 
  {

    header ("location:Transactions.php");
    $tAmount = mysqli_real_escape_string($conn, $_POST['tAmount']);
    $tAccount = mysqli_real_escape_string($conn, $_POST['tAccount']);

    $accountNumINT = (int) $accountNum;

    if ($tAccount != $accountNumINT)
    { 
      $recepient =  "SELECT * from bankAccount WHERE accountNum = '".$tAccount."'";
      $rRecep =  mysqli_query($conn, $recepient);
      $recepR = mysqli_fetch_assoc($rRecep);


      $farah = "SELECT * FROM currencyExchange WHERE currency_codeA = '".$account['currency_code']."' AND currency_codeB = '".$recepR['currency_code']."'";
      $rFarah = mysqli_query($conn, $farah);
      $rate = mysqli_fetch_assoc($rFarah);

    //   echo $rate; 

      $amount_rate = $tAmount * $rate['rate'];
         
      if ($account['balance'] >= $tAmount)
      {


        if ($userType == '01' || $userType == '11')
        {
          $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, teller, transaction_type, transfer_recepient) VALUES ($accountNumINT, $tAmount , CURDATE(),CURTIME(), '$tellerUsername', 'transfer', $tAccount)"; 
          $sql5 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, teller, transaction_type, transfer_sender) VALUES ($tAccount, $amount_rate, CURDATE(),CURTIME(), '$tellerUsername', 'transfer', $accountNumINT)"; 
        }
        else 
        {
          $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, transaction_type, transfer_recepient) VALUES ($accountNumINT, $amount_rate, CURDATE(),CURTIME(), 'transfer', $tAccount)"; 
          $sql5 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, transaction_type, transfer_sender) VALUES ($tAccount, $amount_rate, CURDATE(),CURTIME(), 'transfer', $accountNumINT)"; 

        }
        
        if(mysqli_query($conn, $sql1))
        {
          echo "transaction added";
          require_once ('sms.php');
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        } 

        if(mysqli_query($conn, $sql5))
        {
          echo "transaction added";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        } 

        $sql2 = "UPDATE bankAccount SET balance = balance - '".$tAmount."' WHERE accountNum = '".$accountNumINT."'"; 

        if(mysqli_query($conn, $sql2))
        {
          echo "balance decreased";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        } 

        $sql3 = "UPDATE bankAccount SET balance = balance + '".$amount_rate."' WHERE accountNum = '".$tAccount."'"; 

        if(mysqli_query($conn, $sql3))
        {
          echo "balance increased";
        } 
        else
        {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        } 

      }
    }
      exit();
    }
  else if (isset($_POST['deposit'])) 
  {
    header ("location:Transactions.php");
    $dAmount = mysqli_real_escape_string($conn, $_POST['dAmount']);
    $accountNumINT = (int) $accountNum;

    if ($userType == '01'|| $userType == '11')
      $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, teller, transaction_type) VALUES ($accountNumINT, $dAmount, CURDATE(),CURTIME(), '$tellerUsername', 'deposit')"; 
    else 
       $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, transaction_type) VALUES ($accountNumINT, $dAmount, CURDATE(),CURTIME(), 'deposit')"; 

    if(mysqli_query($conn, $sql1))
    {
      echo "transaction added";
      require_once ('sms.php');
    } 
    else
    {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    } 

    $sql3 = "UPDATE bankAccount SET balance = balance + '".$dAmount."' WHERE accountNum = '".$accountNum."'"; 

      if(mysqli_query($conn, $sql3))
      {
        echo "balance increased";
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      } 
      exit();

  }
  else if (isset($_POST['withdraw'])) 
  {
    header ("location:Transactions.php");
    $wAmount = mysqli_real_escape_string($conn, $_POST['wAmount']);

    $accountNumINT = (int) $accountNum;

    if ($account['balance'] >= $wAmount)
    {
      if ($userType == '01'|| $userType == '11')
        $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, teller, transaction_type) VALUES ($accountNumINT, $wAmount, CURDATE(),CURTIME(), '$tellerUsername', 'withdraw')"; 
      else 
        $sql1 = "INSERT INTO acc_transaction (accountNum, amount, transaction_date, transaction_time, transaction_type) VALUES ($accountNumINT, $wAmount, CURDATE(),CURTIME(), 'withdraw')"; 

      if(mysqli_query($conn, $sql1))
      {
        echo "transaction added";
        require_once ('sms.php');
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      } 

      $sql2 = "UPDATE bankAccount SET balance = balance - '".$wAmount."' WHERE accountNum = '".$accountNumINT."'"; 

      if(mysqli_query($conn, $sql2))
      {
        echo "balance decreased";
      } 
      else
      {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      } 
      exit();
    }

    mysqli_close($conn);
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

      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Create Withdrawal</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <form method = "POST" action="#">
            <input name="wAmount" type="number" class="form-control" id="exampleDropdownWithdrawal" placeholder="Withdrawal Amount">
          <div class=" d-flex justify-content-center align-items-center">
            <button name = "withdraw" type="enter" class="btn btn-dark" >Withdraw</button></a>
          </div>
        </form>
        </div>
      </div>

      <br>
      <br>
      <br>

      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Create Deposit</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <form method = "POST" action = "#">
            <input name="dAmount" type="Deposit Amount" class="form-control" id="exampleDropdownDeposit" placeholder="Deposit Amount">
            <div class=" d-flex justify-content-center align-items-center">
              <button name="deposit" type="enter" class="btn btn-dark" >Deposit</button></a>
            </div>
         </form>
        </div>
      </div>

  	  <br>
      <br>
      <br>


      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Create Transfer</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
          <form method = "POST" action = "#">
            <input name="tAmount" type="number" Amount" class="form-control" id="exampleDropdownDeposit" placeholder="Transfer Amount">
            <input name="tAccount" type="number" class="form-control" id="exampleDropdownDeposit" placeholder="Transfer Account">
          <div class=" d-flex justify-content-center align-items-center">
            <button name="transfer" type="enter" class="btn btn-dark" >transfer</button></a>
          </div>
        </form>
        </div>
      </div>

      <br>
      <br>
      <br>

      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary"><a href="Transactions.php" style="color:white">Transactions</button></a>
      </div>

      <br>
      <br>
      <br>

      <div class="btn-group dropdown d-flex justify-content-center align-items-center">
        <button type="button" class="btn btn-secondary">Balance</button>
        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu">
             <p> <?php echo $account['balance']?></p>
        </div>
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
