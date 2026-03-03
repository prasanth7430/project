<?php
include("../config/db.php");

$id = $_GET['id'] ?? 0;
$id = (int)$id;

$res = $conn->query("SELECT status FROM orders WHERE id = $id");

if($res && $res->num_rows > 0){
  $row = $res->fetch_assoc();
  echo $row['status'];
} else {
  echo "Pending"; // fallback
}