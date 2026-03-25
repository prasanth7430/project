<?php
// InfinityFree Database Details
$host = "sql103.infinityfree.com";  
$user = "if0_41451210";             
$pass = "HIDE";            
$db   = "if0_41451210_restaurant_db"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>