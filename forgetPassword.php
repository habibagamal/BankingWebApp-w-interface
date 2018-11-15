<?php

//session_start();
$new = $_SESSION['new'];
// Get the PHP helper library from twilio.com/docs/php/install
require_once ('Twilio/autoload.php'); // Loads the library
use Twilio\Rest\Client;

$sid = 'AC59979273b57307e0a7f8769b5a79caf6';
$token = '95326e2c66b0da00ba4a157f734ac412';
$client = new Client($sid, $token);

$client->messages->create(
  '+201126438060',
  array(
    'from' => '+1 717 210 4916',
    'body' => 'New password is "'.$new.'". Use it to login.                              ',
  )
);