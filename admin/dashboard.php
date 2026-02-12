<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("Location: login.php");
  exit;
}
include("../config/db.php");

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <a href="logout.php" style="color:white">Logout</a>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<style>
body{margin:0;font-family:Arial;background:#f2f2f2}
header{background:#333;color:#fff;padding:15px;text-align:center}
.card{background:#fff;margin:10px;padding:15px;border-radius:12px}
.status{padding:5px 10px;border-radius:6px;font-size:12px}
.Pending{background:orange;color:#fff}
.Completed{background:green;color:#fff}
button{margin-top:10px;padding:6px 10px;border:none;background:#333;color:#fff;border-radius:6px}
</style>
</head>

<body>

<header>📦 Admin Orders</header>
<?php
$assist = $conn->query("SELECT * FROM assistance_requests WHERE status='Waiting'");
while($a = $assist->fetch_assoc()){
?>
<div style="background:red;color:white;padding:10px;margin:10px;border-radius:8px;">
  🔔 Assistance Needed – Table <?= $a['table_no'] ?>
</div>
<?php } ?>


<?php while($row=$result->fetch_assoc()){ ?>
<div class="card">
  <b>Order #<?= $row['id'] ?></b><br><br>
  Items: <?= $row['items'] ?><br>
  Total: ₹<?= $row['total_price'] ?><br><br>

  <span class="status <?= $row['status'] ?>">
    <?= $row['status'] ?>
  </span>

  <?php if($row['status']=="Pending"){ ?>
    <form method="post" action="update.php">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <button>Mark Completed</button>
    </form>
  <?php } ?>
</div>
<?php } ?>

</body>
</html>
