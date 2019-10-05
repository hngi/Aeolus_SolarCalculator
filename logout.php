<?php

sleep(2);
session_start();

require_once 'oauth.php';

session_destroy();

if (isset($_SESSION['access_token'])) {
	unset($_SESSION['access_token']);
	$client->revokeToken();
}

// Redirect to the login page:
header('Location: /dashboard.php');
