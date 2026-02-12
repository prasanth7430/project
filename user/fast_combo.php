<?php
include("../config/db.php");

$result = $conn->query("SELECT name FROM menu WHERE is_fast=1 LIMIT 2");

$items = [];
while($row = $result->fetch_assoc()){
    $items[] = $row['name'];
}

echo json_encode($items);
?>
