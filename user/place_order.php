<?php
include(__DIR__ . "/../config/db.php");
header('Content-Type: application/json'); // 🔹 Add JSON header

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request method']);
  exit;
}

// 🔹 Sanitize & validate inputs
$table = filter_input(INPUT_POST, 'table_no', FILTER_VALIDATE_INT);
$items = trim($_POST['items'] ?? ''); // 🔹 Keep as string (your format)
$total = filter_input(INPUT_POST, 'total', FILTER_VALIDATE_FLOAT);
$prep_time = filter_input(INPUT_POST, 'prep_time', FILTER_VALIDATE_INT) ?? 0;
$instructions = trim($_POST['special_instructions'] ?? ''); // 🔹 New field

// 🔹 Better validation
if (!$table || empty($items) || !$total || $total <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid order data']);
  exit;
}

try {
  // 🔹 Added special_instructions & created_at
  $stmt = $conn->prepare("INSERT INTO orders 
    (table_no, items, total_price, prep_time, special_instructions, status, created_at) 
    VALUES (?, ?, ?, ?, ?, 'Pending', NOW())");
  
  $stmt->bind_param("isdss", $table, $items, $total, $prep_time, $instructions);

  if ($stmt->execute()) {
    // 🔹 Return JSON with order ID
    echo json_encode([
      'success' => true, 
      'order_id' => $conn->insert_id,
      'message' => 'Order placed successfully'
    ]);
  } else {
    throw new Exception($stmt->error);
  }
} catch (Exception $e) {
  // 🔹 Log error & return safe message
  error_log("Order Error: " . $e->getMessage());
  echo json_encode(['success' => false, 'message' => 'Failed to place order']);
}
?>