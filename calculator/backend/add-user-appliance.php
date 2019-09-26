<?php
include("config.php");
header("allow-control-access-origin: *");
session_start();

$data = json_decode(file_get_contents("php://input"), TRUE);
// echo var_dump($data);

// die();
if ($stmt = $db->prepare('SELECT id FROM user_appliances WHERE user_id = ? AND appliance_id = ?')) {
    $stmt->bind_param('ii', $_SESSION['id'], $d['name']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
}

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id);
    $stmt->fetch();
    if ($stmt = $db->prepare('UPDATE user_appliances SET no=? wattage=? WHERE id = ?')) {
        $stmt->bind_param('iii', $d['no'], $d['wattage'], $id);
        $stmt->execute();
        echo 'Saved!';
    } else {

        echo 'Could not prepare statement!';
    }
} else {
    if ($stmt = $db->prepare('INSERT INTO user_appliances (user_id, appliance_id, no, wattage) VALUES (?, ?, ?, ?)')) {
        $stmt->bind_param('iiii', $_SESSION['id'], $data['name'], $data['no'], $data['wattage']);
        $stmt->execute();
        echo 'Saved!';
    } else {

        echo 'Could not prepare statement!';
    }
}




$stmt->close();
$db->close();
