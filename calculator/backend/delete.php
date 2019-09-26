<?php
header('Content-type: application/json');
include("config.php");
session_start();
$id = $_SESSION['id'];


if ($_GET['index']) {
    $app = $_GET['index'];

    $sql = "DELETE FROM user_appliances WHERE user_id = '" . $id . "' AND appliance_id = '" . $app . "'";

    if (mysqli_query($db, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($db);
    }
}


$db->close();
