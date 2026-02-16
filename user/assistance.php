<?php
include("../config/db.php");

// ✅ Accept BOTH GET and POST
$tableNo = null;

if(isset($_GET['table'])){
  $tableNo = (int)$_GET['table'];
} elseif(isset($_POST['table_no'])){
  $tableNo = (int)$_POST['table_no'];
}

if($tableNo){
  $stmt = $conn->prepare("INSERT INTO assistance_requests (table_no, status) VALUES (?, 'Waiting')");
  if($stmt){
    $stmt->bind_param("i", $tableNo);
    $stmt->execute();
    echo "ok";
  } else {
    echo "error: ".$conn->error;
  }
  exit;
}

// 👇 FETCH waiting assistance (for kitchen)
$res = $conn->query("SELECT id, table_no, request_time FROM assistance_requests WHERE status='Waiting' ORDER BY id DESC");
if(!$res) exit;

while($row = $res->fetch_assoc()){
  $time = !empty($row['request_time'])
    ? date("h:i A", strtotime($row['request_time']))
    : 'just now';

  echo '
  <div class="assist-item">
    <div>
      🔔 Table '.htmlspecialchars($row['table_no']).'
      <small>('.$time.')</small>
    </div>
    <form method="POST" action="../admin/resolve_assist.php">
      <input type="hidden" name="id" value="'.(int)$row['id'].'">
      <button class="btn btn-sm btn-light">Done</button>
    </form>
  </div>';
}