<?php
include(__DIR__ . "/../config/db.php");

$table = $_POST['table_no'];
$items = $_POST['items'];
$total = $_POST['total'];
$prep_time = $_POST['prep_time'];

$sql = "INSERT INTO orders (table_no, items, total_price, prep_time, status)
        VALUES ($table,'$items','$total','$prep_time','Pending')";


if($conn->query($sql)){
    echo $conn->insert_id; // return order id
}else{
    echo "error";
}
?>

<script>
function placeOrder(){
  if(cart.length==0){ alert("Cart empty"); return; }

  let items = cart.map(c=>c.item).join(",");
  let total = cart.reduce((s,c)=>s+c.price,0);

  let form = new FormData();
  form.append("items",items);
  form.append("total",total);

  fetch("place_order.php",{
    method:"POST",
    body:form
  })
  .then(res=>res.text())
  .then(msg=>{
    if(msg=="success"){
      alert("Order Placed Successfully 🎉");
      cart=[];
      document.getElementById("count").innerText=0;
      showHome();
    }else{
      alert("Error");
    }
  });
}
</script>
