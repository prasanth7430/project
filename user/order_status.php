<?php
include("../config/db.php");

$id = $_GET['id'];

$result = $conn->query("SELECT status FROM orders WHERE id=$id");

$row = $result->fetch_assoc();

echo $row['status'];
?>
