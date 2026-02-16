<?php
session_start();
include("../config/db.php");

// 🔐 Allow both admin & kitchen
if(!isset($_SESSION['admin']) || !isset($_SESSION['role']) || 
   !in_array($_SESSION['role'], ['admin', 'kitchen'])){
  header("Location: login.php");
  exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $id     = $_POST['id'] ?? null;
  $status = $_POST['status'] ?? null;

  if($id && $status){
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
  }
}

// 🔁 Redirect back correctly
if($_SESSION['role'] === 'kitchen'){
  header("Location: kitchen.php");
} else {
  header("Location: dashboard.php");
}
exit;