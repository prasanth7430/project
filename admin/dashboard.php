<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit;
}
include("../config/db.php");

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

/* 📊 Stats Queries */
$totalOrders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$totalRevenue = $conn->query("SELECT SUM(total_price) as revenue FROM orders")->fetch_assoc()['revenue'];
$activeOrders = $conn->query("SELECT COUNT(*) as active FROM orders WHERE status!='Completed'")->fetch_assoc()['active'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin_style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="premium-layout">

  <!-- Sidebar -->
  <div class="premium-sidebar">
    <h2>🍽 MK Admin</h2>
    <nav>
      <a href="dashboard.php" class="active">📊 Dashboard</a>
      <a href="qr.php">📱 QR Codes</a>
      <a href="logout.php">🚪 Logout</a>
    </nav>
  </div>

  <!-- Main -->
  <div class="premium-main">

    <!-- Topbar -->
    <div class="premium-top">
      <h4>📦 Live Orders</h4>
      <div class="live-indicator">
        <span class="pulse-dot"></span> Kitchen Active
      </div>
    </div>

    <!-- 📊 Stats -->
    <div class="stats-grid">
      <div class="stat-box">
        <h4>Total Orders</h4>
        <p><?= $totalOrders ?></p>
      </div>
      <div class="stat-box">
        <h4>Total Revenue</h4>
        <p>₹ <?= $totalRevenue ?? 0 ?></p>
      </div>
      <div class="stat-box">
        <h4>Active Orders</h4>
        <p><?= $activeOrders ?></p>
      </div>
    </div>

    <!-- 📈 Chart -->
    <div class="glass-card">
      <h5>Orders Overview</h5>
      <canvas id="ordersChart"></canvas>
    </div>

    <!-- 🔔 Assistance Alerts -->
    <?php
    $assist = $conn->query("SELECT * FROM assistance_requests WHERE status='Waiting'");
    while($a = $assist->fetch_assoc()){
    ?>
      <div class="assist-banner">
        🔔 Assistance Needed – Table <?= $a['table_no'] ?>
      </div>
    <?php } ?>

    <!-- Orders Grid -->
    <div class="orders-grid" id="ordersContainer">
      <?php while($row=$result->fetch_assoc()){ ?>
      <div class="order-glass">

        <div class="order-head">
          <span>Order #<?= $row['id'] ?></span>
          <span class="status <?= strtolower($row['status']) ?>">
            <?= $row['status'] ?>
          </span>
        </div>

        <p><strong>Table:</strong> <?= $row['table_no'] ?? '-' ?></p>
        <p><strong>Items:</strong> <?= $row['items'] ?></p>
        <p class="price">₹<?= $row['total_price'] ?></p>

        <form method="POST" action="update.php">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <select name="status" onchange="this.form.submit()">
            <option <?= $row['status']=="Pending"?'selected':'' ?>>Pending</option>
            <option <?= $row['status']=="Preparing"?'selected':'' ?>>Preparing</option>
            <option <?= $row['status']=="Completed"?'selected':'' ?>>Completed</option>
          </select>
        </form>

      </div>
      <?php } ?>
    </div>

  </div>
</div>

<script>
fetch("chart_data.php")
.then(res=>res.json())
.then(data=>{
  new Chart(document.getElementById('ordersChart'),{
    type:'line',
    data:{
      labels:data.labels,
      datasets:[{
        label:'Orders',
        data:data.values,
        borderColor:'#ff6a00',
        fill:false,
        tension:0.3
      }]
    }
  });
});

let lastOrderId = 0;

fetch("latest_order.php")
.then(res=>res.text())
.then(id=> lastOrderId = parseInt(id));

function refreshOrders(){
  fetch("orders_partial.php")
  .then(res=>res.text())
  .then(html=>{
    document.getElementById("ordersContainer").innerHTML = html;
  });
}

function showToast(message){
  const toast = document.createElement("div");
  toast.className = "premium-toast";
  toast.innerText = message;
  document.body.appendChild(toast);
  setTimeout(()=> toast.classList.add("show"),100);
  setTimeout(()=> toast.remove(),4000);
}

function checkNewOrders(){
  fetch("latest_order.php")
  .then(res=>res.text())
  .then(id=>{
    id = parseInt(id);
    if(id > lastOrderId){
      showToast("🔥 New Order Received!");
      lastOrderId = id;
    }
  });
}

setInterval(()=>{
  refreshOrders();
  checkNewOrders();
},5000);
</script>

</body>
</html>