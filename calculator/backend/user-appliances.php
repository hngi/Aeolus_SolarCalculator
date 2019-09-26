<?php
header('Content-type: application/json');
include("config.php");
session_start();
$id = $_SESSION['id'];

$sth = mysqli_query($db, "SELECT * from user_appliances WHERE user_id = '" . $id . "'");
$rows = array();
while ($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);
$db->close();
