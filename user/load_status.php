<?php
include("../config/db.php");

$result = $conn->query("SELECT COUNT(*) as total FROM orders 
                        WHERE status='Pending' OR status='Preparing'");

$row = $result->fetch_assoc();
$count = $row['total'];

$status = "Low";
$wait = 10;

if($count >=3 && $count <=5){
    $status = "Medium";
    $wait = 20;
}
elseif($count >=6){
    $status = "High";
    $wait = 30;
}

echo json_encode([
    "status"=>$status,
    "waiting_time"=>$wait
]);
?>
