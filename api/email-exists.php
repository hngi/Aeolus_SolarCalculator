<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once dirname(__DIR__) . '/src/User.php';

if (empty($_POST['email']) || !isset($_POST['email'])) {
	print json_encode(['message' => 'Email is required', 'code' => 'd030']);
	exit;
}

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
    print json_encode(['message' => 'Email is not valid', 'code' => 'f030']);
    exit;
}

$email = new User;

print $email->is_email_exists($_POST['email']);

