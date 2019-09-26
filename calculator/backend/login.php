<?php
//include database configuration
include("config.php");

header("allow-control-access-origin: *");

$_POST = json_decode(file_get_contents("php://input"), TRUE);
//start session
session_start();

//check if input fields contain data or not 
if (!isset($_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    die('Please fill both the email and password fields!');
}

if (empty($_POST['email']) || empty($_POST['password'])) {
    // email or password field empty
    die('Email and password are required');
}

// Using prepared SQL statements to prevent SQL injection
if ($stmt = $db->prepare('SELECT id, name, password FROM users WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
}
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name, $password);
    $stmt->fetch();
    // Account exists, now we verify the password.
    if (password_verify($_POST['password'], $password)) {
        //if password matches log in users using session
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['id'] = $id;

        echo 'Login Successful!';
    } else {
        http_response_code(401);
        echo 'Incorrect password!';
    }
} else {
    http_response_code(401);
    echo 'Incorrect email!';
}
$stmt->close();
