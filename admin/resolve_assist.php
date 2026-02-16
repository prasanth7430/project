<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['admin'])) exit;

$id = $_POST['id'] ?? null;

if($id){
  $conn->query("UPDATE assistance_requests SET status='Done' WHERE id=$id");
}

header("Location: kitchen.php");
exit;