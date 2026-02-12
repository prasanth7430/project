<?php
session_start();

if(isset($_POST['login'])){
  $user = $_POST['username'];
  $pass = $_POST['password'];

  if($user=="admin" && $pass=="1234"){
    $_SESSION['admin']=true;
    header("Location: dashboard.php");
  }else{
    $error="Invalid Login";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:Arial;background:#f2f2f2}
.card{background:#fff;margin:100px auto;padding:20px;width:300px;border-radius:12px}
input,button{width:100%;padding:10px;margin-top:10px}
button{background:#333;color:#fff;border:none}
.error{color:red;text-align:center}
</style>
</head>
<body>

<div class="card">
<h3>🔐 Admin Login</h3>

<form method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
</div>


</body>
</html>
