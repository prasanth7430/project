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

<div class="admin-layout">

  <!-- Sidebar -->
  <div class="sidebar">
    <h4>🍽 MK Admin</h4>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="qr.php">📱 QR Codes</a>
    <a href="logout.php">🚪 Logout</a>
  </div>

  <!-- Main -->
  <div class="main">

    <!-- Topbar -->
    <div class="topbar">
      <h4>📦 Live Orders</h4>
      <div>
        <button onclick="toggleDark()" class="btn btn-dark btn-sm">🌙</button>
        <span class="badge bg-danger ms-2">Kitchen Active</span>
      </div>
    </div>

    <!-- 📊 Stats -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="stat-card bg-primary text-white p-3 rounded">
          <h6>Total Orders</h6>
          <h3><?= $totalOrders ?></h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card bg-success text-white p-3 rounded">
          <h6>Total Revenue</h6>
          <h3>₹ <?= $totalRevenue ?? 0 ?></h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card bg-warning text-dark p-3 rounded">
          <h6>Active Orders</h6>
          <h3><?= $activeOrders ?></h3>
        </div>
      </div>
    </div>

    <!-- 📈 Chart -->
    <div class="card p-4 mb-4">
      <h5>Orders Overview</h5>
      <canvas id="ordersChart"></canvas>
    </div>

    <!-- 🔔 Assistance Alerts -->
    <?php
    $assist = $conn->query("SELECT * FROM assistance_requests WHERE status='Waiting'");
    while($a = $assist->fetch_assoc()){
    ?>
      <div class="alert alert-danger">
        🔔 Assistance Needed – Table <?= $a['table_no'] ?>
      </div>
    <?php } ?>

    <!-- Orders Grid -->
    <div class="row" id="ordersContainer">

      <?php while($row=$result->fetch_assoc()){ ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-3">

          <h6>Order #<?= $row['id'] ?></h6>
          <p><strong>Table:</strong> <?= $row['table_no'] ?? '-' ?></p>
          <p><strong>Items:</strong> <?= $row['items'] ?></p>
          <p><strong>Total:</strong> ₹<?= $row['total_price'] ?></p>

          <!-- Status Badge -->
          <span class="badge 
            <?php 
              if($row['status']=="Pending") echo "bg-warning";
              elseif($row['status']=="Preparing") echo "bg-primary";
              elseif($row['status']=="Completed") echo "bg-success";
              else echo "bg-secondary";
            ?>">
            <?= $row['status'] ?>
          </span>

          <!-- Status Dropdown -->
          <form method="POST" action="update.php" class="mt-3">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <select name="status" class="form-select" onchange="this.form.submit()">
              <option <?= $row['status']=="Pending"?'selected':'' ?>>Pending</option>
              <option <?= $row['status']=="Preparing"?'selected':'' ?>>Preparing</option>
              <option <?= $row['status']=="Completed"?'selected':'' ?>>Completed</option>
            </select>
          </form>

        </div>
      </div>
      <?php } ?>

    </div>

  </div>
</div>

<!-- 🔊 Sound -->
<audio id="newOrderSound" src="https://www.soundjay.com/buttons/sounds/button-3.mp3"></audio>

<script>

/* 🌙 Dark Mode */
function toggleDark(){
  document.body.classList.toggle("dark-mode");
}

/* 📈 Load Chart */
fetch("/restaurant_app/admin/chart_data.php")
.then(res=>res.json())
.then(data=>{
  new Chart(document.getElementById('ordersChart'),{
    type:'line',
    data:{
      labels:data.labels,
      datasets:[{
        label:'Orders',
        data:data.values,
        borderColor:'#ff5722',
        fill:false,
        tension:0.3
      }]
    }
  });
});

/* 🔔 New Order Sound + Auto Refresh */
let lastOrderId = 0;

fetch("/restaurant_app/admin/latest_order.php")
.then(res=>res.text())
.then(id=>{
  lastOrderId = parseInt(id);
});

function refreshOrders(){
  fetch("/restaurant_app/admin/orders_partial.php")
  .then(res=>res.text())
  .then(html=>{
    document.getElementById("ordersContainer").innerHTML = html;
  });
}

function checkNewOrders(){
  fetch("/restaurant_app/admin/latest_order.php")
  .then(res=>res.text())
  .then(id=>{
    id = parseInt(id);
    if(id > lastOrderId){
      document.getElementById("newOrderSound").play();
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
