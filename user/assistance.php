<?php
include("../config/db.php");

$table = $_POST['table_no'];


$sql = "INSERT INTO assistance_requests (table_no) VALUES ($table)";

if($conn->query($sql)){
    echo "success";
}else{
    echo "error";
}
?>
