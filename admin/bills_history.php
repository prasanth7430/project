<?php
session_start();
if(!isset($_SESSION['admin']) || $_SESSION['role'] !== 'admin'){
  header("Location: login.php");
  exit;
}
include("../config/db.php");

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bill History</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="premium-layout">
  <div class="premium-sidebar">
    <h2>🍽 MK Admin</h2>
    <nav>
      <a href="dashboard.php">📊 Dashboard</a>
      <a href="bills_history.php" class="active">🧾 Bills</a>
      <a href="logout.php">🚪 Logout</a>
    </nav>
  </div>

  <div class="premium-main">
    <h3>🧾 Bill History</h3>

    <table class="table table-dark table-striped mt-3">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Table</th>
          <th>Total</th>
          <th>Status</th>
          <th>Bill</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=$result->fetch_assoc()){ ?>
        <tr>
          <td>#<?= $row['id'] ?></td>
          <td><?= $row['table_no'] ?></td>
          <td>₹<?= $row['total_price'] ?></td>
          <td><?= $row['status'] ?></td>
          <td>
            <a href="bill.php?id=<?= $row['id'] ?>" target="_blank">🧾 View</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

  </div>
</div>

</body>
</html>