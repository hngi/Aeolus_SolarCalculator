<?php require ("vendor/autoload.php");

$client_id = '';
$client_secret = '';
$redirect_uri = '';

// $redirect_uri = 'http://localhost:500/my-account.php';

// 1. enter your google account credentials
$client = new Google_Client();
$client->setApplicationName("Google OAuth Login With PHP");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);

// $client->setScopes("email");

$client->addScope("email");
$client->addScope("profile");

$objRes = new Google_Service_Oauth2($client);

//Add access token to php session after successfully authenticate
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $_SESSION['loggedin'] = true;
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

//set token
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}

//store with user data
if ($client->getAccessToken()) {
  $userData = $objRes->userinfo->get();
  if(!empty($userData)) {
    //insert data into database
    $_SESSION['name'] = $userData->name;
    $_SESSION['email'] = $userData->email;
  }
  $_SESSION['access_token'] = $client->getAccessToken();
}
