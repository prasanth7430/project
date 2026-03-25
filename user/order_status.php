<?php
// load_status.php - Order Status Checker (JSON API)

include("../config/db.php");
header('Content-Type: application/json');

// 🔹 Helper: Status label for UI (Must be before usage)
function getStatusLabel($status) {
  $labels = [
    'Pending' => 'Order Received',
    'Preparing' => 'Kitchen Preparing',
    'Ready' => 'Ready to Serve',
    'Served' => 'Served',
    'Cancelled' => 'Cancelled'
  ];
  return $labels[$status] ?? $status;
}

// 🔹 Helper: Status color for UI
function getStatusColor($status) {
  $colors = [
    'Pending' => '#ffc107',
    'Preparing' => '#17a2b8',
    'Ready' => '#28a745',
    'Served' => '#6c757d',
    'Cancelled' => '#dc3545'
  ];
  return $colors[$status] ?? '#6c757d';
}

// 🔹 Get & validate order ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
  echo json_encode([
    'success' => false, 
    'message' => 'Invalid order ID',
    'status' => 'unknown'
  ]);
  exit;
}

try {
  // 🔹 Prepared statement - SQL Injection prevention
  $stmt = $conn->prepare("SELECT id, table_no, status, prep_time, total_price, special_instructions, created_at, updated_at FROM orders WHERE id = ?");
  
  if (!$stmt) {
    throw new Exception("Prepare failed: " . $conn->error);
  }
  
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result && $result->num_rows > 0) {
    $order = $result->fetch_assoc();
    
    // 🔹 Calculate estimated ready time
    $created = strtotime($order['created_at']);
    $prepMinutes = (int)($order['prep_time'] ?? 10);
    $estimatedReady = date('h:i A', $created + ($prepMinutes * 60));
    
    // 🔹 Return full order data
    echo json_encode([
      'success' => true,
      'order' => [
        'id' => $order['id'],
        'table_no' => $order['table_no'],
        'status' => $order['status'],
        'prep_time' => $order['prep_time'],
        'total_price' => $order['total_price'],
        'special_instructions' => $order['special_instructions'],
        'created_at' => $order['created_at'],
        'updated_at' => $order['updated_at'],
        'estimated_ready' => $estimatedReady,
        'status_label' => getStatusLabel($order['status']),
        'status_color' => getStatusColor($order['status'])
      ]
    ]);
    
  } else {
    echo json_encode([
      'success' => false, 
      'message' => 'Order not found',
      'status' => 'not_found'
    ]);
  }
  
  $stmt->close();
  
} catch (Exception $e) {
  error_log("Status Check Error [" . $id . "]: " . $e->getMessage());
  echo json_encode([
    'success' => false, 
    'message' => 'Failed to fetch order status',
    'status' => 'error'
  ]);
}
?>