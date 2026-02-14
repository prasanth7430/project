<?php
include("../config/db.php");
$row = $conn->query("SELECT id FROM orders ORDER BY id DESC LIMIT 1")->fetch_assoc();
echo $row['id'] ?? 0;
?>
