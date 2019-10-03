<?php
include("config.php");
header("allow-control-access-origin: *");
session_start();

$data = json_decode(file_get_contents("php://input"), TRUE);
//echo var_dump($data[0]['name']);

if (count($data)) {
    foreach ($data as $d) {
        if ($stmt = $db->prepare('INSERT INTO user_appliances (user_id, appliance_id, no, wattage) VALUES (?, ?, ?, ?)')) {
            $stmt->bind_param('iiii', $_SESSION['id'], $d['name'], $d['no'], $d['wattage']);
            $stmt->execute();
        } else {

            echo 'Could not prepare statement!';
        }
    }

    $stmt->close();
    $db->close();
}


echo 'Saved!';
