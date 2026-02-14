<?php
include("../config/db.php");

$data = [];
$labels = [];

$result = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as total 
                        FROM orders 
                        GROUP BY DATE(created_at)");

while($row = $result->fetch_assoc()){
    $labels[] = $row['date'];
    $data[] = $row['total'];
}

echo json_encode([
    "labels"=>$labels,
    "values"=>$data
]);
