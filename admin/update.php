<?php
include("../config/db.php");

$id = $_POST['id'];
$conn->query("UPDATE orders SET status='Completed' WHERE id=$id");

header("Location: dashboard.php");
?>
