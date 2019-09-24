<?php
//include database configuration
include("config.php");

// Make sure the submitted registration values are not empty.
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirmation'])) {
    // One or more values are empty.
    die('Please complete the registration form');
}

if ($_POST['password'] != $_POST['password_confirmation']) {
    die('password does not match');
}

//check to see if account username exists in our database.
if ($stmt = $db->prepare('SELECT id FROM users WHERE email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in our database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'Email exists, please choose another one !';
    } else {
        if ($stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)')) {

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['name'], $_POST['email'], $password);
            $stmt->execute();
            echo 'You have successfully registered, you can now login!! ';
        } else {

            echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
} else {
    echo 'Could not prepare statement!';
}
$db->close();
