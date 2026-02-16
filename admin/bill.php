<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit;
}
include("../config/db.php");

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
  die("Order not found");
}

$subtotal = (float)$order['total_price'];
$gstRate = 0.05; // 5% GST
$gst = $subtotal * $gstRate;
$grandTotal = $subtotal + $gst;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bill - Order #<?= $order['id'] ?></title>
<style>
  body{font-family:Arial;background:#f5f5f5;padding:20px;}
  .bill{max-width:380px;margin:auto;background:#fff;padding:20px;border-radius:8px;}
  .logo{text-align:center;}
  .logo img{max-width:80px;}
  h2{text-align:center;margin:10px 0;}
  .row{display:flex;justify-content:space-between;margin:6px 0;}
  .total{font-weight:bold;border-top:1px dashed #ccc;padding-top:10px;}
  .print{text-align:center;margin-top:15px;}
  button{padding:8px 16px;}
</style>
</head>
<body>

<div class="bill" id="billArea">
  <div class="logo">
    <!-- 🔁 Change logo path -->
    <img src="logo.png" alt="Hotel Logo">
  </div>

  <h2>MK Restaurant</h2>
  <p style="text-align:center;">Order #<?= $order['id'] ?> | Table <?= $order['table_no'] ?></p>
  <hr>

  <div class="row">
    <span>Items</span>
    <span><?= htmlspecialchars($order['items']) ?></span>
  </div>

  <div class="row">
    <span>Subtotal</span>
    <span>₹<?= number_format($subtotal,2) ?></span>
  </div>

  <div class="row">
    <span>GST (5%)</span>
    <span>₹<?= number_format($gst,2) ?></span>
  </div>

  <div class="row total">
    <span>Total</span>
    <span>₹<?= number_format($grandTotal,2) ?></span>
  </div>

  <p style="text-align:center;margin-top:10px;">Thank you! Visit again 😊</p>
</div>

<div class="print">
  <button onclick="window.print()">🖨 Print / Save PDF</button>
</div>

</body>
</html>