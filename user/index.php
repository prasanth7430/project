<?php
$table_no = isset($_GET['table']) ? (int)$_GET['table'] : 1;
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🍽 MK Restaurant</title>

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css">
  
  <style>
    /* ===== Status Box ===== */
    .status-box {
      margin: 10px auto;
      max-width: 420px;
      padding: 15px 20px;
      border-radius: 15px;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      text-align: center;
      font-weight: 600;
      color: #fff;
      border: 1px solid rgba(255,255,255,0.2);
      transition: all 0.3s ease;
    }
    
    .status-box.pending { background: rgba(255, 193, 7, 0.2); border-color: #ffc107; }
    .status-box.preparing { background: rgba(23, 162, 184, 0.2); border-color: #17a2b8; }
    .status-box.ready { background: rgba(40, 167, 69, 0.2); border-color: #28a745; }
    .status-box.served { background: rgba(108, 117, 125, 0.2); border-color: #6c757d; }
    
    /* ===== Progress Bar ===== */
    .progress-wrap {
      max-width: 420px;
      margin: 0 auto 15px;
      padding: 15px;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      border: 1px solid rgba(255,255,255,0.2);
    }
    
    .progress { 
      height: 12px; 
      background: rgba(255,255,255,0.2);
      border-radius: 10px;
      overflow: hidden;
    }
    
    .progress-bar {
      transition: width 0.5s ease;
      border-radius: 10px;
    }
    
    .eta {
      font-size: 14px;
      opacity: 0.9;
      margin-top: 10px;
      color: rgba(255,255,255,0.95);
    }
    
    .order-id {
      font-size: 12px;
      opacity: 0.8;
      margin-top: 5px;
    }
    
    /* ===== Bill Lines ===== */
    .bill-line { 
      font-size: 14px; 
      margin-bottom: 8px; 
      color: rgba(255,255,255,0.95);
    }
    
    /* ===== Combo Suggestion ===== */
    #comboSuggestion {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.7; }
    }
    
    /* ===== Dark Mode Toggle ===== */
    .dark-mode-toggle {
      position: fixed;
      top: 15px;
      right: 15px;
      z-index: 1000;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .dark-mode-toggle:hover {
      background: rgba(255,255,255,0.3);
      transform: scale(1.1);
    }
    
    /* ===== Responsive ===== */
    @media (max-width: 480px) {
      .status-box, .progress-wrap {
        margin: 10px 15px;
        padding: 12px 15px;
      }
    }
  </style>
</head>

<body>

<!-- Dark Mode Toggle -->
<button onclick="toggleDark()" class="dark-mode-toggle" title="Toggle Dark Mode">
  <i class="fas fa-moon"></i>
</button>

<!-- Assistance Button -->
<div class="assist-btn">
  <button onclick="callAssistance()" title="Call Staff">
    <i class="fas fa-bell"></i>
  </button>
</div>

<!-- Header -->
<header class="text-center py-3">
  <h3 class="text-white mb-0">🍽 MK Restaurant</h3>
  <small class="text-white-50">Table #<?= htmlspecialchars($table_no) ?></small>
</header>

<!-- Order Status Section -->
<div id="statusBox" class="status-box">
  <i class="fas fa-info-circle me-2"></i>
  <span id="statusText">No Active Order</span>
  <div class="order-id" id="orderIdDisplay"></div>
</div>

<!-- Progress Bar (Hidden by default) -->
<div class="progress-wrap d-none" id="progressWrap">
  <div class="progress">
    <div id="orderProgress" class="progress-bar" style="width: 0%"></div>
  </div>
  <div class="eta" id="etaText">
    <i class="fas fa-clock me-1"></i>
    <span id="etaValue">--:--</span>
  </div>
</div>

<!-- Loading & Messages -->
<div id="loadAlert" class="text-center fw-bold mt-2"></div>
<div id="comboSuggestion" class="text-center fw-bold text-warning mb-3"></div>

<!-- Menu Section -->
<div class="container py-2">
  <!-- Search -->
  <div class="mb-3">
    <div class="input-group">
      <span class="input-group-text bg-white border-0">
        <i class="fas fa-search text-muted"></i>
      </span>
      <input type="text" id="searchFood" placeholder="Search food..." 
             onkeyup="searchItem()" class="form-control border-0 shadow-sm">
    </div>
  </div>

  <!-- Category Filters -->
  <div class="text-center mb-3">
    <button onclick="filterCategory('all')" class="btn btn-outline-light btn-sm me-1 active-filter">All</button>
    <button onclick="filterCategory('Burger')" class="btn btn-outline-light btn-sm me-1">Burger</button>
    <button onclick="filterCategory('Rice')" class="btn btn-outline-light btn-sm me-1">Rice</button>
    <button onclick="filterCategory('Italian')" class="btn btn-outline-light btn-sm">Italian</button>
  </div>

  <!-- Menu Items Grid -->
  <div class="row" id="menuItems">
    <!-- Items loaded by script.js -->
  </div>
</div>

<!-- Floating Cart Bar -->
<div class="glass-cart" onclick="openCart()">
  <i class="fas fa-shopping-cart me-2"></i>
  <span id="count">0</span> Items  
  <span class="total-price">₹ <span id="liveTotal">0</span></span>
</div>

<!-- Cart Drawer -->
<div class="cart-drawer" id="cartDrawer">
  <div class="drawer-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="fas fa-shopping-basket me-2"></i>Your Cart</h5>
    <span onclick="closeCart()" style="cursor:pointer; font-size:1.5rem;">&times;</span>
  </div>

  <div id="cartItems" class="p-2"></div>

  <!-- Bill Summary -->
  <div class="drawer-footer p-3">
    <div class="bill-line d-flex justify-content-between">
      <span>Subtotal</span>
      <span>₹ <span id="billSubtotal">0</span></span>
    </div>
    <div class="bill-line d-flex justify-content-between">
      <span>GST (5%)</span>
      <span>₹ <span id="billGST">0</span></span>
    </div>
    <div class="bill-line d-flex justify-content-between">
      <span>Service (2%)</span>
      <span>₹ <span id="billService">0</span></span>
    </div>
    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">
    <div class="bill-line d-flex justify-content-between fw-bold fs-5">
      <span>Total</span>
      <span>₹ <span id="billGrand">0</span></span>
    </div>

    <!-- Special Instructions -->
    <textarea id="specialInstructions" class="form-control mt-3 mb-2" 
              placeholder="📝 Any special requests? (optional)" rows="2"></textarea>

    <button onclick="placeOrder()" class="btn btn-success w-100 py-2 fw-bold">
      <i class="fas fa-check-circle me-2"></i>Place Order
    </button>
  </div>
</div>

<!-- Hidden input for table no (for script.js) -->
<input type="hidden" id="tableNo" value="<?= $table_no ?>">
<input type="hidden" id="currentOrderId" value="<?= $order_id ?>">

<!-- Main Script -->
<script src="script.js"></script>

<!-- Status Check Script (Enhanced) -->
<script>
// ===== ORDER STATUS AUTO-CHECK (JSON API) =====
let statusInterval = null;

function checkOrderStatus(orderId) {
  if (!orderId) return;
  
  fetch(`load_status.php?id=${orderId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const order = data.order;
        updateStatusUI(order);
        
        // Stop polling if order is completed
        if (['Ready', 'Served', 'Cancelled'].includes(order.status)) {
          stopStatusCheck();
          if (order.status === 'Ready') {
            showReadyNotification();
          }
        }
      } else {
        // Order not found or error
        document.getElementById('statusBox').innerHTML = 
          '<i class="fas fa-info-circle me-2"></i><span id="statusText">No Active Order</span>';
        document.getElementById('progressWrap').classList.add('d-none');
      }
    })
    .catch(err => {
      console.error('Status check error:', err);
      document.getElementById('loadAlert').innerHTML = 
        '<span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Connection error</span>';
    });
}

function updateStatusUI(order) {
  const statusBox = document.getElementById('statusBox');
  const progressWrap = document.getElementById('progressWrap');
  const progressBar = document.getElementById('orderProgress');
  const etaValue = document.getElementById('etaValue');
  const statusText = document.getElementById('statusText');
  const orderIdDisplay = document.getElementById('orderIdDisplay');
  
  // Show progress section
  progressWrap.classList.remove('d-none');
  
  // Update status text & styling
  statusText.innerText = order.status_label;
  statusBox.className = `status-box ${order.status.toLowerCase()}`;
  statusBox.style.borderColor = order.status_color;
  
  // Show order ID
  orderIdDisplay.innerHTML = `<i class="fas fa-hashtag me-1"></i>Order #${order.id}`;
  
  // Update progress bar
  const progressMap = {
    'Pending': 25,
    'Preparing': 65,
    'Ready': 100,
    'Served': 100,
    'Cancelled': 0
  };
  progressBar.style.width = `${progressMap[order.status] || 0}%`;
  
  // Update progress bar color & animation
  const colorMap = {
    'Pending': 'bg-warning',
    'Preparing': 'bg-info',
    'Ready': 'bg-success',
    'Served': 'bg-secondary',
    'Cancelled': 'bg-danger'
  };
  progressBar.className = `progress-bar ${colorMap[order.status] || 'bg-secondary'} progress-bar-striped progress-bar-animated`;
  
  // Update ETA
  etaValue.innerText = order.estimated_ready || '--:--';
  
  // Update prep time info
  if (order.prep_time) {
    etaValue.innerHTML += ` <small class="opacity-75">(~${order.prep_time} min)</small>`;
  }
}

function showReadyNotification() {
  Swal.fire({
    icon: 'success',
    title: '🎉 Your Order is Ready!',
    html: `<p class="mb-0">Table #${document.getElementById('tableNo').value}</p>
           <small class="text-muted">Please collect from counter</small>`,
    timer: 6000,
    showConfirmButton: false,
    background: '#1e1e1e',
    color: '#fff'
  });
}

function startStatusCheck(orderId) {
  stopStatusCheck();
  checkOrderStatus(orderId); // Immediate first check
  statusInterval = setInterval(() => checkOrderStatus(orderId), 15000); // Every 15 sec
}

function stopStatusCheck() {
  if (statusInterval) {
    clearInterval(statusInterval);
    statusInterval = null;
  }
}

// ===== PAGE LOAD HANDLER =====
document.addEventListener('DOMContentLoaded', function() {
  // Load menu & cart (from script.js)
  if (typeof loadMenu === 'function') loadMenu();
  if (typeof loadCartFromStorage === 'function') loadCartFromStorage();
  if (typeof updateCartUI === 'function') updateCartUI();
  
  // Start status check if order_id exists
  const orderId = document.getElementById('currentOrderId').value;
  if (orderId && orderId > 0) {
    startStatusCheck(orderId);
  }
  
  // Load dark mode preference
  if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    document.querySelector('.dark-mode-toggle i').className = 'fas fa-sun';
  }
});

// ===== DARK MODE TOGGLE =====
function toggleDark() {
  document.body.classList.toggle('dark-mode');
  const isDark = document.body.classList.contains('dark-mode');
  localStorage.setItem('darkMode', isDark);
  
  // Toggle icon
  const icon = document.querySelector('.dark-mode-toggle i');
  icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
}

// ===== CALL ASSISTANCE =====
function callAssistance() {
  const tableNo = document.getElementById('tableNo').value;
  
  Swal.fire({
    title: '🔔 Call Staff?',
    html: `<p>Request assistance for <strong>Table #${tableNo}</strong></p>`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Call!',
    cancelButtonText: 'Cancel',
    confirmButtonColor: '#ff512f',
    background: '#1e1e1e',
    color: '#fff'
  }).then((result) => {
    if (result.isConfirmed) {
      // Send assistance request to backend
      fetch('assist_request.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `table_no=${tableNo}`
      })
      .then(res => res.text())
      .then(response => {
        Swal.fire({
          icon: 'success',
          title: '✅ Staff Notified!',
          text: 'Someone will assist you shortly',
          timer: 3000,
          showConfirmButton: false,
          background: '#1e1e1e',
          color: '#fff'
        });
      })
      .catch(err => {
        Swal.fire('Error', 'Could not send request', 'error');
      });
    }
  });
}

// ===== SEARCH & FILTER (Compatible with script.js) =====
function searchItem() {
  if (typeof window.searchMenu === 'function') {
    const query = document.getElementById('searchFood').value;
    window.searchMenu(query);
  }
}

function filterCategory(category) {
  // Update active button style
  document.querySelectorAll('.text-center.mb-3 .btn').forEach(btn => {
    btn.classList.remove('active', 'btn-light');
    btn.classList.add('btn-outline-light');
  });
  event.target.classList.remove('btn-outline-light');
  event.target.classList.add('active', 'btn-light');
  
  if (typeof window.filterCategory === 'function') {
    window.filterCategory(category);
  }
}
</script>

</body>
</html>