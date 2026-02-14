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

</head>

<body>

<!-- 🌙 Dark Mode Button -->
<button onclick="toggleDark()" 
        class="btn btn-sm btn-light position-fixed end-0 me-3 mt-3"
        style="z-index:1000;">
🌙
</button>

<!-- 🔔 Floating Assistance Button -->
<div class="assist-btn">
  <button onclick="callAssistance()">🔔</button>
</div>

<header class="text-center py-3 text-white">
  <h3>🍽 MK Restaurant</h3>
</header>

<div id="statusBox" class="status-box">
  No Active Order
</div>

<div id="loadAlert" class="text-center fw-bold mt-2"></div>
<div id="comboSuggestion" class="text-center fw-bold text-warning mb-3"></div>

<div class="container py-4">

  <!-- 🔍 Search -->
  <input type="text"
         id="searchFood"
         placeholder="🔍 Search food..."
         onkeyup="searchItem()"
         class="form-control mb-3">

  <!-- 📂 Category Buttons -->
  <div class="text-center mb-3">
    <button onclick="filterCategory('all')" class="btn btn-outline-dark btn-sm">All</button>
    <button onclick="filterCategory('Burger')" class="btn btn-outline-dark btn-sm">Burger</button>
    <button onclick="filterCategory('Rice')" class="btn btn-outline-dark btn-sm">Rice</button>
    <button onclick="filterCategory('Italian')" class="btn btn-outline-dark btn-sm">Italian</button>
  </div>

  <div class="row" id="menuItems"></div>

</div>

<!-- 🛒 Glass Cart Bar -->
<div class="glass-cart" onclick="openCart()">
  🛒 <span id="count">0</span> Items  
  <span class="total-price">₹ <span id="liveTotal">0</span></span>
</div>

<!-- 🛒 Sliding Cart Drawer -->
<div class="cart-drawer" id="cartDrawer">
  <div class="drawer-header d-flex justify-content-between">
    <h5>Your Cart</h5>
    <span onclick="closeCart()" style="cursor:pointer;">✖</span>
  </div>

  <div id="cartItems" class="p-3"></div>

  <div class="drawer-footer p-3 text-center">
    <b>Total: ₹ <span id="drawerTotal">0</span></b>
    <br>
    <button onclick="placeOrder()" class="btn btn-success mt-2 w-100">
      Place Order
    </button>
  </div>
</div>

<script>
let tableNo = <?php echo $table_no; ?>;
</script>

<script src="script.js"></script>

</body>
</html>
