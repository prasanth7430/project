<?php
$table_no = isset($_GET['table']) ? $_GET['table'] : 1;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Restaurant</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.status-box{
  margin: 10px auto;
  max-width: 420px;
  padding: 12px;
  border-radius: 12px;
  background: rgba(255,255,255,0.85);
  text-align: center;
  font-weight: 600;
}
.progress-wrap{
  max-width: 420px;
  margin: 0 auto 10px;
  padding: 10px;
  background: rgba(255,255,255,0.85);
  border-radius: 12px;
}
.progress{ height: 10px; }
.eta{ font-size: 13px; opacity: 0.8; margin-top: 6px; }
.bill-line{ font-size:14px; margin-bottom:6px; }
</style>
</head>

<body>

<button onclick="toggleDark()" class="btn btn-sm btn-light position-fixed end-0 me-3 mt-3" style="z-index:1000;">🌙</button>

<div class="assist-btn">
  <button onclick="callAssistance()">🔔</button>
</div>

<header class="text-center py-3 text-white">
  <h3>🍽 MK Restaurant</h3>
</header>

<div id="statusBox" class="status-box">No Active Order</div>

<div class="progress-wrap d-none" id="progressWrap">
  <div class="progress">
    <div id="orderProgress" class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%"></div>
  </div>
  <div class="eta" id="etaText"></div>
</div>

<div id="loadAlert" class="text-center fw-bold mt-2"></div>
<div id="comboSuggestion" class="text-center fw-bold text-warning mb-3"></div>

<div class="container py-4">
  <input type="text" id="searchFood" placeholder="🔍 Search food..." onkeyup="searchItem()" class="form-control mb-3">

  <div class="text-center mb-3">
    <button onclick="filterCategory('all')" class="btn btn-outline-dark btn-sm">All</button>
    <button onclick="filterCategory('Burger')" class="btn btn-outline-dark btn-sm">Burger</button>
    <button onclick="filterCategory('Rice')" class="btn btn-outline-dark btn-sm">Rice</button>
    <button onclick="filterCategory('Italian')" class="btn btn-outline-dark btn-sm">Italian</button>
  </div>

  <div class="row" id="menuItems"></div>
</div>

<div class="glass-cart" onclick="openCart()">
  🛒 <span id="count">0</span> Items  
  <span class="total-price">₹ <span id="liveTotal">0</span></span>
</div>

<div class="cart-drawer" id="cartDrawer">
  <div class="drawer-header d-flex justify-content-between">
    <h5>Your Cart</h5>
    <span onclick="closeCart()" style="cursor:pointer;">✖</span>
  </div>

  <div id="cartItems" class="p-3"></div>

  <!-- 🧾 Live Bill -->
  <div class="drawer-footer p-3 text-center">
    <div class="bill-line d-flex justify-content-between">
      <span>Subtotal</span>
      <span>₹ <span id="billSubtotal">0</span></span>
    </div>
    <div class="bill-line d-flex justify-content-between">
      <span>GST (5%)</span>
      <span>₹ <span id="billGST">0</span></span>
    </div>
    <div class="bill-line d-flex justify-content-between">
      <span>Service Charge (2%)</span>
      <span>₹ <span id="billService">0</span></span>
    </div>
    <hr>
    <div class="bill-line d-flex justify-content-between fw-bold">
      <span>Grand Total</span>
      <span>₹ <span id="billGrand">0</span></span>
    </div>

    <button onclick="placeOrder()" class="btn btn-success mt-2 w-100">
      Place Order
    </button>
  </div>
</div>

<script>
let tableNo = <?php echo (int)$table_no; ?>;

function checkOrderStatus(){
  let id = localStorage.getItem("order_id");
  if(!id) return;

  fetch("order_status.php?id="+id)
  .then(res=>res.text())
  .then(status=>{
    const box = document.getElementById("statusBox");
    const wrap = document.getElementById("progressWrap");
    const bar  = document.getElementById("orderProgress");
    const eta  = document.getElementById("etaText");

    wrap.classList.remove("d-none");

    if(status=="Pending"){
      box.innerHTML = "🕒 Order Received";
      bar.style.width = "25%";
      bar.className = "progress-bar bg-warning progress-bar-striped progress-bar-animated";
      eta.innerHTML = "⏳ ETA: 15–20 mins";
    }
    else if(status=="Preparing"){
      box.innerHTML = "👨‍🍳 Preparing your food";
      bar.style.width = "65%";
      bar.className = "progress-bar bg-info progress-bar-striped progress-bar-animated";
      eta.innerHTML = "🔥 ETA: 8–12 mins";
    }
    else if(status=="Completed" || status=="Served"){
      box.innerHTML = "✅ Order Ready / Served";
      bar.style.width = "100%";
      bar.className = "progress-bar bg-success";
      eta.innerHTML = "🍽 Enjoy your meal!";
      localStorage.removeItem("order_id");
      setTimeout(()=>{ wrap.classList.add("d-none"); }, 4000);
    }
  });
}
setInterval(checkOrderStatus, 5000);
</script>

<script src="script.js"></script>
</body>
</html>