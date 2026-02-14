<?php
include "../admin/db.php";

$sql = "SELECT COUNT(*) as total FROM orders WHERE status='Pending' OR status='Preparing'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$total_orders = $row['total'];

if($total_orders >= 5){
    $status = "High";
}
elseif($total_orders >= 3){
    $status = "Medium";
}
else{
    $status = "Low";
}

// waiting time calculation
$waiting_time = $total_orders * 5;  // 1 order = 5 mins approx

echo json_encode([
    "status"=>$status,
    "waiting_time"=>$waiting_time
]);
?>
<?php
header('Content-Type: application/json');

echo json_encode([
 "status"=>"High",
 "waiting_time"=>20
]);
?>
