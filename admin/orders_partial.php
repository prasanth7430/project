<?php
session_start();
if(!isset($_SESSION['admin'])){
  http_response_code(401);
  exit;
}
include("../config/db.php");

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

while($row = $result->fetch_assoc()){
  $statusClass = strtolower($row['status']);
?>
  <div class="order-glass">
    <div class="order-head">
      <span>Order #<?= htmlspecialchars($row['id']) ?></span>
      <span class="status <?= $statusClass ?>">
        <?= htmlspecialchars($row['status']) ?>
      </span>
    </div>

    <p><strong>Table:</strong> <?= htmlspecialchars($row['table_no']) ?></p>
    <p><strong>Items:</strong> <?= htmlspecialchars($row['items']) ?></p>
    <p class="price">₹<?= htmlspecialchars($row['total_price']) ?></p>

    <!-- 🔄 Status Update -->
    <form method="POST" action="update.php">
      <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
      <select name="status" onchange="this.form.submit()">
        <option <?= $row['status']=="Pending"?'selected':'' ?>>Pending</option>
        <option <?= $row['status']=="Preparing"?'selected':'' ?>>Preparing</option>
        <option <?= $row['status']=="Completed"?'selected':'' ?>>Completed</option>
      </select>
    </form>

    <!-- 🧾 Print Bill Button -->
    <a href="bill.php?id=<?= htmlspecialchars($row['id']) ?>" 
       target="_blank" 
       style="display:block;margin-top:8px;text-decoration:none;">
      <button type="button" class="btn btn-sm btn-outline-light w-100">
        🧾 Print Bill
      </button>
    </a>

  </div>
<?php } ?>