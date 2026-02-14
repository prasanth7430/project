<?php
include("../config/db.php");

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

while($row=$result->fetch_assoc()){
?>
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
