<?php
// 🔧 Ensure session cookie works across admin pages
ini_set('session.cookie_path', '/');
session_start();

include("../config/db.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // DB uses md5
  $password = md5($password);

  $stmt = $conn->prepare("SELECT id, role FROM users WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $res = $stmt->get_result();

  if($res && $res->num_rows === 1){
    $user = $res->fetch_assoc();

    // ✅ Set session
    $_SESSION['admin'] = (int)$user['id'];
    $_SESSION['role']  = trim(strtolower($user['role'])); // normalize

    // 🔁 Redirect by role
    if($_SESSION['role'] === 'admin'){
      header("Location: dashboard.php");
    } elseif($_SESSION['role'] === 'kitchen'){
      header("Location: kitchen.php");
    } else {
      $error = "Invalid role configuration";
    }
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body>
  <div class="login-card">
    <h2>Login</h2>
    <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>