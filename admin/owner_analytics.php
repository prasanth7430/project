<?php
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin'){
  http_response_code(401);
  exit;
}
include("../config/db.php");

$range = $_GET['range'] ?? 'today';

$where = "1=1";
if($range === 'yesterday'){
  $where = "DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
}
if($range === '7days'){
  $where = "DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
}
if($range === 'today'){
  $where = "DATE(created_at) = CURDATE()";
}

/* 🕒 Orders by Hour (Peak Time) */
$hourRes = $conn->query("
  SELECT HOUR(created_at) as hr, COUNT(*) as cnt 
  FROM orders 
  WHERE $where
  GROUP BY hr ORDER BY hr
");

$hours = [];
$counts = [];
while($r = $hourRes->fetch_assoc()){
  $hours[] = str_pad($r['hr'], 2, "0", STR_PAD_LEFT) . ":00";
  $counts[] = (int)$r['cnt'];
}

/* 🏆 Top Selling Items */
$itemRes = $conn->query("SELECT items FROM orders WHERE $where");

$itemCount = [];
while($r = $itemRes->fetch_assoc()){
  $items = explode(",", $r['items']);
  foreach($items as $it){
    $it = trim($it);
    if(!$it) continue;
    $itemCount[$it] = ($itemCount[$it] ?? 0) + 1;
  }
}

arsort($itemCount);
$topItems = array_slice($itemCount, 0, 5, true);

echo json_encode([
  "hours" => $hours,
  "counts" => $counts,
  "top_items_labels" => array_keys($topItems),
  "top_items_values" => array_values($topItems)
]);