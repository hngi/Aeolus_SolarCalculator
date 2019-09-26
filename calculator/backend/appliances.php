<?php
header('Content-type: application/json');
include("config.php");

$sth = mysqli_query($db, "SELECT * from appliances");
$rows = array();
while ($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);
$db->close();
