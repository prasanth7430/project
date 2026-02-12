<?php
$table_no = isset($_GET['table']) ? $_GET['table'] : 1;
$table_no = isset($_GET['table']) ? $_GET['table'] : 2;
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <div id="comboSuggestion" style="padding:10px;text-align:center;color:#ff5722;font-weight:bold;"></div>

  <div id="loadAlert" style="padding:10px;text-align:center;font-weight:bold;"></div>

    <link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#ff5722">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restaurant App</title>

<style>
body{margin:0;font-family:Arial;background:#f2f2f2}
header{background:#ff5722;color:#fff;padding:15px;text-align:center}
.menu,.cart{padding-bottom:90px}
.card{background:#fff;margin:10px;padding:15px;border-radius:12px;display:flex;justify-content:space-between;align-items:center}
button{background:#ff5722;color:#fff;border:none;padding:8px 12px;border-radius:8px}
.bottom{position:fixed;bottom:0;width:100%;background:#fff;display:flex;border-top:1px solid #ccc}
.bottom div{flex:1;text-align:center;padding:10px}
.badge{background:red;color:#fff;border-radius:50%;padding:2px 6px;font-size:12px}
.hide{display:none}
.total{padding:15px;font-weight:bold}
</style>
</head>

<style>
body{
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg,#1e3c72,#2a5298);
  min-height:100vh;
}

.glass-card{
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
  border-radius:20px;
  color:white;
  transition:0.3s ease;
}

.glass-card:hover{
  transform: scale(1.05);
  box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.fade-in{
  animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn{
  from{opacity:0; transform:translateY(20px);}
  to{opacity:1; transform:translateY(0);}
}
</style>




<body class="bg-light">

<header id="title">🍽️ Food Order App</header>
<div id="statusBox" style="
  background:#fff3cd;
  color:#856404;
  padding:12px;
  margin:10px;
  border-radius:8px;
  font-weight:bold;
  text-align:center;">
  No Active Order
</div>

<!-- HOME / MENU -->
<div id="home" class="menu">
  <div class="card">
    <div><b>Dosa</b><br>₹50</div>
    <button onclick="addToCart('Dosa',50)">Add</button>
  </div>
  <div class="card">
    <div><b>Idli</b><br>₹30</div>
    <button onclick="addToCart('Idli',30)">Add</button>
  </div>
</div>

<div class="container py-4">

  <h2 class="text-center mb-4">🍽 Digital Menu</h2>

  <div id="statusBox" class="alert alert-warning text-center">
    No Active Order
  </div>

  <div class="row" id="menuItems">
  </div>
  <div class="card mt-4 shadow">
    <div class="card-body">
      <h5>🛒 Cart (<span id="count">0</span>)</h5>
      <button class="btn btn-success w-100 mt-2" onclick="placeOrder()">
        Place Order
      </button>
    </div>
  </div>
  <div class="text-center mt-3">
    <button class="btn btn-dark" onclick="callAssistance()">
      🔔 Need Assistance
    </button>
  <br><br> </div>

<!-- CART -->
<div id="cart" class="cart hide">
  <div id="cartItems"></div>
  <div class="total">Total: ₹<span id="total">0</span></div>
  <div style="padding:15px">
    <button style="width:100%" onclick="placeOrder()">Place Order</button>
  </div>
</div>

<!-- BOTTOM NAV -->
<div class="bottom">
  <div onclick="showHome()">🏠 Home</div>
  <div onclick="showCart()">🛒 Cart <span id="count" class="badge">0</span></div>
  <div>📦 Orders</div>
</div>

<script>
  let tableNo = <?php echo $table_no; ?>;

let cart=[];

function addToCart(item,price){
  cart.push({item,price});
  document.getElementById("count").innerText = cart.length;
}

function showCart(){
  document.getElementById("home").classList.add("hide");
  document.getElementById("cart").classList.remove("hide");
  document.getElementById("title").innerText="🛒 Your Cart";

  let html="", total=0;
  cart.forEach(c=>{
    html+=`<div class="card"><b>${c.item}</b><span>₹${c.price}</span></div>`;
    total+=c.price;
  });
  document.getElementById("cartItems").innerHTML = html || "<p style='padding:15px'>Cart empty</p>";
  document.getElementById("total").innerText = total;
}

function showHome(){
  document.getElementById("cart").classList.add("hide");
  document.getElementById("home").classList.remove("hide");
  document.getElementById("title").innerText="🍽️ Food Order App";
}
//place order

function placeOrder(){
  if(cart.length==0){ 
    alert("Cart empty"); 
    return; 
  }

  let items = cart.map(c=>c.item).join(",");
  let total = cart.reduce((s,c)=>s+c.price,0);
  let prep_time = cart.reduce((s,c)=>s+(c.prep||10),0);

  let form = new FormData();
  form.append("table_no",tableNo);
  form.append("items",items);
  form.append("total",total);
  form.append("prep_time",prep_time);

  fetch("place_order.php",{
    method:"POST",
    body:form
  })
  .then(res=>res.text())
  .then(orderId=>{
    if(orderId!="error"){
      localStorage.setItem("order_id",orderId);
      alert("Order Placed Successfully 🎉");
      cart=[];
      document.getElementById("count").innerText=0;
      checkOrderStatus();
    }else{
      alert("Error placing order");
    }
  });
}

// check kitchen load

function checkLoad(){
  fetch("load_status.php")
  .then(res=>res.json())
  .then(data=>{
    let msg="";
    if(data.status=="High"){
      msg = "🔴 High Demand. Estimated waiting time: "+data.waiting_time+" minutes";
    }
    else if(data.status=="Medium"){
      msg = "🟡 Moderate orders. Waiting time: "+data.waiting_time+" minutes";
    }
    else{
      msg = "🟢 Kitchen available. Waiting time: "+data.waiting_time+" minutes";
    }

    document.getElementById("loadAlert").innerText = msg;

    checkCombo(data.status);
  });
}

checkLoad();
setInterval(checkLoad,5000);

// combo suggestion based on load

function checkCombo(status){
  if(status=="High"){
    fetch("fast_combo.php")
    .then(res=>res.json())
    .then(items=>{
      if(items.length>0){
        document.getElementById("comboSuggestion").innerText =
          "🔥 Fast Combo Available Now – "+items.join(" + ");
      }
    });
  }else{
    document.getElementById("comboSuggestion").innerText="";
  }
}

//call assistance

function callAssistance(){
  let form = new FormData();
  form.append("table_no",tableNo);


  fetch("assistance.php",{
    method:"POST",
    body:form
  })
  .then(res=>res.text())
  .then(msg=>{
    if(msg=="success"){
      alert("Staff will assist you shortly.");
    }else{
      alert("Error sending request");
    }
  });
}
// check order status

function checkOrderStatus(){
  let id = localStorage.getItem("order_id");
  if(!id) return;

  fetch("order_status.php?id="+id)
  .then(res=>res.text())
  .then(status=>{
    let box = document.getElementById("statusBox");

    if(status=="Pending"){
      box.innerHTML = "🕒 Order Received";
      box.style.background="#ffeeba";
    }
    else if(status=="Preparing"){
      box.innerHTML = "👨‍🍳 Preparing Your Food";
      box.style.background="#bee5eb";
    }
    else if(status=="Served"){
  box.innerHTML = "✅ Order Served";
  box.style.background="#c3e6cb";
  localStorage.removeItem("order_id");

  setTimeout(()=>{
    box.innerHTML = "No Active Order";
    box.style.background="#fff3cd";
  },5000);
}

  });
}
html += `
<div class="col-md-4 mb-3">
  <div class="card shadow-sm">
    <div class="card-body text-center">
      <h5>${item.name}</h5>
      <p>₹ ${item.price}</p>
      <button class="btn btn-primary btn-sm" onclick="addToCart('${item.name}',${item.price},${item.prep})">
        Add
      </button>
    </div>
  </div>
</div>
`;
html += `
<div class="col-md-4 mb-4 fade-in">
  <div class="glass-card p-3 text-center">
    <img src="${item.image}" class="img-fluid rounded mb-3" style="height:150px;object-fit:cover;">
    <h5>${item.name}</h5>
    <p>₹ ${item.price}</p>
    <button class="btn btn-light btn-sm mt-2"
      onclick="addToCart('${item.name}',${item.price},${item.prep})">
      Add to Cart
    </button>
  </div>
</div>
`;

let menu = [
 {name:"Burger", price:120, prep:10, image:"images/burger.jpg"},
 {name:"Pizza", price:250, prep:15, image:"images/pizza.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"}
];

</script>

</body>
</html>
