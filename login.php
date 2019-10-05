<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/src/User.php';


//start session
session_set_cookie_params(2678400);
session_start();

if (isset($_SESSION['loggedin'])) {
	header('Location: /dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] != 'POST')
	header('Location: /my-account.php');

$login = new User;

if (!isset($_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    json_encode(['message' => 'Please fill both the email and password fields!']);
}

if (empty($_POST['email']) || empty($_POST['password'])) {
    // email or password field empty
    json_encode(['message' => 'Email and password are required']);
}

sleep(2);

print $login->grant_access();
