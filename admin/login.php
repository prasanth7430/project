<?php
session_start();
include("../config/db.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $username = $_POST['username'] ?? '';
  $password = md5($_POST['password'] ?? '');
  $role     = $_POST['role'] ?? '';

  $stmt = $conn->prepare("SELECT id, role FROM users WHERE username=? AND password=? AND role=?");
  $stmt->bind_param("sss", $username, $password, $role);
  $stmt->execute();
  $res = $stmt->get_result();

  if($res && $res->num_rows === 1){
    $user = $res->fetch_assoc();
    $_SESSION['admin'] = $user['id'];
    $_SESSION['role']  = $user['role'];

    if($user['role'] === 'admin'){
      header("Location: dashboard.php");
    } else {
      header("Location: kitchen.php");
    }
    exit;
  } else {
    $error = "❌ Invalid login details";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>MK Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="bg"></div>

<div class="glass-login animate-in">
  <!-- 🖼 Logo -->
  <div class="logo-wrap">
    <img src="logo.png" alt="Restaurant Logo" id="logoImg">
  </div>

  <h2>🍽 MK Admin</h2>
  <p class="subtitle">Sign in to continue</p>

  <?php if($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="input-group">
      <input type="text" name="username" required>
      <label>Username</label>
    </div>

    <div class="input-group">
      <input type="password" name="password" id="pass" required>
      <label>Password</label>
      <span class="eye" onclick="togglePass()">👁</span>
    </div>

    <select name="role" class="role-select" required>
      <option value="">Select Role</option>
      <option value="admin">Owner</option>
      <option value="kitchen">Kitchen</option>
    </select>

    <button type="submit" class="login-btn">Login</button>
  </form>

  <p class="footer">iOS Glass UI ✨</p>
</div>

<script>
function togglePass(){
  const p = document.getElementById("pass");
  p.type = p.type === "password" ? "text" : "password";
}
</script>

</body>
</html>