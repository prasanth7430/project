<?php
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin'){
  header("Location: login.php");
  exit;
}
include("../config/db.php");

$totalOrders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$totalRevenue = $conn->query("SELECT SUM(total_price) as revenue FROM orders")->fetch_assoc()['revenue'];
$todayRevenue = $conn->query("SELECT SUM(total_price) as revenue FROM orders WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['revenue'] ?? 0;
$todayOrders  = $conn->query("SELECT COUNT(*) as total FROM orders WHERE DATE(created_at)=CURDATE()")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Owner Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin_style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="premium-layout">
  <div class="premium-sidebar">
    <h2>🍽 MK Admin</h2>
    <nav>
      <a href="dashboard.php" class="active">📊 Owner Dashboard</a>
      <a href="bills_history.php">🧾 Bills</a>
      <a href="kitchen.php">👨‍🍳 Kitchen</a>
      <a href="qr.php">📱 QR Codes</a>
      <a href="logout.php">🚪 Logout</a>
    </nav>
  </div>

  <div class="premium-main">
    <div class="premium-top">
      <h4>📊 Owner Analytics</h4>
      <select id="range" class="form-select w-auto" onchange="loadAnalytics()">
        <option value="today">Today</option>
        <option value="yesterday">Yesterday</option>
        <option value="7days">Last 7 Days</option>
      </select>
    </div>

    <div class="stats-grid">
      <div class="stat-box"><h4>Total Orders</h4><p><?= $totalOrders ?></p></div>
      <div class="stat-box"><h4>Total Revenue</h4><p>₹ <?= $totalRevenue ?? 0 ?></p></div>
      <div class="stat-box"><h4>Today Orders</h4><p><?= $todayOrders ?></p></div>
      <div class="stat-box"><h4>Today Revenue</h4><p>₹ <?= $todayRevenue ?></p></div>
    </div>

    <div class="glass-card">
      <h5>📈 Orders by Hour (Peak Time)</h5>
      <canvas id="peakChart"></canvas>
    </div>

    <div class="glass-card mt-4">
      <h5>🏆 Top Selling Items</h5>
      <canvas id="topItemsChart"></canvas>
    </div>
  </div>
</div>

<script>
let peakChart, topItemsChart;

function loadAnalytics(){
  const range = document.getElementById("range").value;

  fetch("owner_analytics.php?range="+range)
  .then(res=>res.json())
  .then(data=>{
    if(peakChart) peakChart.destroy();
    if(topItemsChart) topItemsChart.destroy();

    peakChart = new Chart(document.getElementById('peakChart'),{
      type:'bar',
      data:{
        labels:data.hours,
        datasets:[{
          label:'Orders',
          data:data.counts,
          borderWidth:1
        }]
      }
    });

    topItemsChart = new Chart(document.getElementById('topItemsChart'),{
      type:'doughnut',
      data:{
        labels:data.top_items_labels,
        datasets:[{
          data:data.top_items_values
        }]
      }
    });
  });
}

loadAnalytics();
</script>

</body>
</html>