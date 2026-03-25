// ===== GLOBAL VARIABLES =====
let cart = [];
let menu = [
  {id:1, name:"Burger", price:120, prep:10, image:"images/burger.jpg", category:"Burger"},
  {id:2, name:"Pizza", price:250, prep:15, image:"images/pizza.jpg", category:"Italian"},
  {id:3, name:"Pasta", price:180, prep:12, image:"images/pasta.jpg", category:"Italian"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"},
  {id:4, name:"Chicken Biriyani", price:180, prep:20, image:"images/biriyani.jpg", category:"Rice"}

];

let tableNo = parseInt(document.getElementById('tableNo')?.value) || 1;
let statusInterval = null;

// ===== PAGE LOAD =====
document.addEventListener('DOMContentLoaded', function() {
  loadMenu();
  loadCartFromStorage();
  updateCartUI();
  
  // Dark mode
  if(localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    const icon = document.querySelector('.dark-mode-toggle i');
    if(icon) icon.className = 'fas fa-sun';
  }
  
  // Status check
  const orderId = document.getElementById('currentOrderId')?.value;
  if(orderId && orderId > 0) startStatusCheck(orderId);
});

// ===== LOAD MENU =====
function loadMenu(filter = 'all') {
  const container = document.getElementById('menuItems');
  if(!container) return;
  
  let filtered = menu.filter(item => 
    filter === 'all' || item.category === filter
  );
  
  let html = '';
  filtered.forEach((item, index) => {
    const cartItem = cart.find(c => c.id === item.id);
    const currentQty = cartItem ? cartItem.qty : 0;
    
    html += `
    <div class="col-6 col-md-4 fade-in" data-category="${item.category}" style="animation-delay: ${index * 0.05}s">
      <div class="glass-card text-center h-100">
        <img src="${item.image}" class="img-fluid mb-3" alt="${item.name}" 
             onerror="this.src='https://via.placeholder.com/200?text=${item.name}'">
        <h6 class="fw-bold mb-2">${item.name}</h6>
        <p class="text-warning fw-bold mb-2">₹${item.price}</p>
        <small class="text-muted d-block mb-3">
          <i class="fas fa-clock"></i> ${item.prep} mins
        </small>
        <div class="d-flex justify-content-center gap-2">
          <button class="btn btn-sm btn-outline-danger" onclick="changeQty(${item.id}, -1)" style="width:35px;height:35px;border-radius:10px;font-weight:bold;">
            −
          </button>
          <span id="qty-${item.id}" class="fw-bold px-3 py-2" style="min-width:40px;display:inline-flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.1);border-radius:10px;">
            ${currentQty}
          </span>
          <button class="btn btn-sm btn-outline-success" onclick="changeQty(${item.id}, 1)" style="width:35px;height:35px;border-radius:10px;font-weight:bold;">
            +
          </button>
        </div>
      </div>
    </div>`;
  });
  container.innerHTML = html;
}

// ===== CHANGE QUANTITY - FIXED =====
function changeQty(itemId, change) {
  console.log('changeQty called:', itemId, change);
  
  const item = menu.find(m => m.id === itemId);
  if(!item) {
    console.error('Item not found:', itemId);
    return;
  }
  
  const cartIndex = cart.findIndex(c => c.id === itemId);
  
  if(cartIndex > -1) {
    // Item exists in cart
    cart[cartIndex].qty += change;
    if(cart[cartIndex].qty <= 0) {
      cart.splice(cartIndex, 1);
    }
  } else if(change > 0) {
    // Add new item to cart
    cart.push({
      id: item.id,
      name: item.name,
      price: Number(item.price),
      prep: Number(item.prep),
      image: item.image,
      category: item.category,
      qty: 1
    });
  }
  
  console.log('Cart updated:', cart);
  
  // Update qty display in menu
  updateMenuQtyDisplay(itemId);
  
  // Update cart UI
  updateCartUI();
  
  // Save to localStorage
  saveCartToStorage();
  
  // Visual feedback
  if(navigator.vibrate) navigator.vibrate(30);
}

// ===== UPDATE MENU QTY DISPLAY =====
function updateMenuQtyDisplay(itemId) {
  const qtySpan = document.getElementById(`qty-${itemId}`);
  if(qtySpan) {
    const cartItem = cart.find(c => c.id === itemId);
    const newQty = cartItem ? cartItem.qty : 0;
    qtySpan.innerText = newQty;
    
    // Animation
    qtySpan.style.transform = 'scale(1.2)';
    setTimeout(() => qtySpan.style.transform = 'scale(1)', 150);
  }
}

// ===== UPDATE CART UI - FIXED =====
function updateCartUI() {
  const floatingCart = document.getElementById('floatingCart');
  const countEl = document.getElementById('count');
  const liveTotalEl = document.getElementById('liveTotal');
  const btnTotalEl = document.getElementById('btnTotal');
  
  // Calculate totals
  const totalItems = cart.reduce((sum, c) => sum + c.qty, 0);
  const subtotal = cart.reduce((s, c) => s + (c.price * c.qty), 0);
  const gst = Math.round(subtotal * 0.05);
  const service = Math.round(subtotal * 0.02);
  const grandTotal = subtotal + gst + service;
  
  // Update displays
  if(countEl) countEl.innerText = totalItems;
  if(liveTotalEl) liveTotalEl.innerText = Math.round(grandTotal);
  if(btnTotalEl) btnTotalEl.innerText = Math.round(grandTotal);
  if(document.getElementById('billSubtotal')) document.getElementById('billSubtotal').innerText = Math.round(subtotal);
  if(document.getElementById('billGST')) document.getElementById('billGST').innerText = gst;
  if(document.getElementById('billService')) document.getElementById('billService').innerText = service;
  if(document.getElementById('billGrand')) document.getElementById('billGrand').innerText = Math.round(grandTotal);
  
  // Show/hide floating cart
  if(floatingCart) {
    if(totalItems > 0) floatingCart.classList.remove('hidden');
    else floatingCart.classList.add('hidden');
  }
  
  // Render cart items
  renderCartItems();
}

// ===== RENDER CART ITEMS - FIXED WITH WORKING BUTTONS =====
function renderCartItems() {
  const container = document.getElementById('cartItems');
  if(!container) return;
  
  if(cart.length === 0) {
    container.innerHTML = `
      <div class="text-center py-4 text-muted">
        <i class="fas fa-shopping-cart fa-3x mb-3" style="opacity:0.3"></i>
        <p>Your cart is empty</p>
        <small>Add some delicious items!</small>
      </div>`;
    return;
  }
  
  let html = '';
  cart.forEach((item, index) => {
    html += `
      <div class="cart-item-wrapper" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:14px;padding:12px;margin-bottom:10px;">
        <div style="display:flex;align-items:center;gap:12px;">
          <img src="${item.image || 'https://via.placeholder.com/50'}" 
               class="cart-item-img" 
               style="width:45px;height:45px;object-fit:cover;border-radius:10px;"
               alt="${item.name}"
               onerror="this.src='https://via.placeholder.com/50?text=Food'">
          
          <div style="flex:1;min-width:0;">
            <div style="font-weight:600;font-size:0.9rem;margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
              ${item.name}
            </div>
            <div style="color:#f7c548;font-weight:700;font-size:0.85rem;">
              ₹${item.price} × ${item.qty} = <strong>₹${item.price * item.qty}</strong>
            </div>
          </div>
          
          <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.1);padding:4px;border-radius:10px;">
            <button onclick="updateCartQty(${index}, -1)" 
                    class="qty-btn minus"
                    style="width:28px;height:28px;border:none;border-radius:8px;background:#e74c3c;color:white;font-weight:bold;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
              −
            </button>
            <span style="font-weight:700;font-size:0.95rem;min-width:24px;text-align:center;">${item.qty}</span>
            <button onclick="updateCartQty(${index}, 1)" 
                    class="qty-btn plus"
                    style="width:28px;height:28px;border:none;border-radius:8px;background:#2ecc71;color:white;font-weight:bold;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;">
              +
            </button>
          </div>
        </div>
      </div>
    `;
  });
  
  container.innerHTML = html;
}

// ===== UPDATE CART QTY - NEW FUNCTION =====
function updateCartQty(index, change) {
  console.log('updateCartQty called:', index, change);
  
  if(!cart[index]) {
    console.error('Cart item not found at index:', index);
    return;
  }
  
  const itemId = cart[index].id;
  
  cart[index].qty += change;
  
  if(cart[index].qty <= 0) {
    cart.splice(index, 1);
  }
  
  // Update menu display
  updateMenuQtyDisplay(itemId);
  
  // Update cart UI
  updateCartUI();
  
  // Save
  saveCartToStorage();
  
  // Feedback
  if(navigator.vibrate) navigator.vibrate(30);
}

// ===== REMOVE FROM CART =====
function removeFromCart(itemId) {
  cart = cart.filter(c => c.id !== itemId);
  
  // Reset menu qty
  updateMenuQtyDisplay(itemId);
  
  updateCartUI();
  saveCartToStorage();
}

// ===== LOCAL STORAGE =====
function saveCartToStorage() {
  localStorage.setItem('restaurant_cart', JSON.stringify(cart));
}

function loadCartFromStorage() {
  const saved = localStorage.getItem('restaurant_cart');
  if(saved) {
    try {
      cart = JSON.parse(saved);
      // Update all menu qty displays
      cart.forEach(c => updateMenuQtyDisplay(c.id));
    } catch(e) {
      console.error('Cart load error:', e);
      cart = [];
    }
  }
}

// ===== CART OPEN/CLOSE =====
function openCart() {
  const drawer = document.getElementById('cartDrawer');
  const overlay = document.getElementById('cartOverlay');
  
  if(drawer) {
    drawer.classList.add('active');
    if(window.innerWidth <= 480) drawer.classList.add('compact');
  }
  if(overlay) overlay.classList.add('active');
  document.body.style.overflow = 'hidden';
  updateCartUI();
}

function closeCart() {
  const drawer = document.getElementById('cartDrawer');
  const overlay = document.getElementById('cartOverlay');
  
  if(drawer) {
    drawer.classList.add('closing');
    setTimeout(() => drawer.classList.remove('active', 'closing', 'compact'), 350);
  }
  if(overlay) overlay.classList.remove('active');
  document.body.style.overflow = '';
}

// ===== PLACE ORDER =====
function placeOrder() {
  if(cart.length === 0) {
    Swal.fire({
      icon: "warning",
      title: "Cart is empty!",
      text: "Add some items first",
      confirmButtonColor: "#ff6b35",
      background: '#1e1e2e',
      color: '#fff'
    });
    return;
  }

  Swal.fire({
    title: 'Placing Order...',
    html: 'Please wait',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading(),
    background: '#1e1e2e',
    color: '#fff'
  });

  const items = cart.map(c => `${c.name} x${c.qty}`).join(", ");
  const subtotal = cart.reduce((s, c) => s + (c.price * c.qty), 0);
  const gst = Math.round(subtotal * 0.05);
  const service = Math.round(subtotal * 0.02);
  const total = subtotal + gst + service;
  const prep_time = Math.max(...cart.map(c => c.prep));
  const instructions = document.getElementById('specialInstructions')?.value || '';

  const form = new FormData();
  form.append("table_no", tableNo);
  form.append("items", items);
  form.append("total", total);
  form.append("prep_time", prep_time);
  form.append("special_instructions", instructions);

  fetch("place_order.php", { method: "POST", body: form })
    .then(res => res.json())
    .then(data => {
      Swal.close();
      
      if(data.success) {
        closeCart();
        
        cart = [];
        document.querySelectorAll("[id^='qty-']").forEach(e => e.innerText = "0");
        updateCartUI();
        saveCartToStorage();
        
        Swal.fire({
          title: "✅ Order Confirmed!",
          html: `<div style="text-align:left;">
            <p><strong>Order ID:</strong> #${data.order_id}</p>
            <p><strong>Table:</strong> ${tableNo}</p>
            <hr style="border-color:rgba(255,255,255,0.2)">
            <p>Total: ₹${total}</p>
          </div>`,
          icon: "success",
          confirmButtonText: "Track Order",
          confirmButtonColor: "#2ecc71",
          background: '#1e1e2e',
          color: '#fff'
        }).then(() => {
          window.location.href = `order_status.php?order_id=${data.order_id}`;
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Order Failed ❌",
          text: data.message || "Try again",
          confirmButtonColor: "#ff6b35",
          background: '#1e1e2e',
          color: '#fff'
        });
      }
    })
    .catch(err => {
      Swal.close();
      console.error('Fetch error:', err);
      Swal.fire({
        icon: "error",
        title: "Connection Error",
        text: "Check internet & try again",
        confirmButtonColor: "#ff6b35",
        background: '#1e1e2e',
        color: '#fff'
      });
    });
}

// ===== DARK MODE =====
function toggleDark() {
  document.body.classList.toggle("dark-mode");
  localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
  const icon = document.querySelector('.dark-mode-toggle i');
  if(icon) icon.className = document.body.classList.contains('dark-mode') ? 'fas fa-sun' : 'fas fa-moon';
}

// ===== SEARCH & FILTER =====
function filterCategory(category, btn) {
  if(btn) {
    document.querySelectorAll('.text-center.mb-3 .btn').forEach(b => {
      b.classList.remove('active');
      b.style.background = '';
      b.style.border = '';
    });
    btn.classList.add('active');
    btn.style.background = '#ff6b35';
    btn.style.border = 'none';
  }
  loadMenu(category);
}

function searchMenu(query) {
  const searchTerm = query.toLowerCase();
  const items = document.querySelectorAll('#menuItems > div');
  items.forEach(div => {
    const name = div.querySelector('h6')?.innerText.toLowerCase() || '';
    div.style.display = name.includes(searchTerm) ? 'block' : 'none';
  });
}

// ===== ORDER STATUS =====
function checkOrderStatus(orderId) {
  if(!orderId) return;
  
  fetch(`load_status.php?id=${orderId}`)
    .then(res => res.json())
    .then(data => {
      if(data.success) {
        updateStatusUI(data.order);
        if(['Ready','Served','Cancelled'].includes(data.order.status)) {
          stopStatusCheck();
          if(data.order.status === 'Ready') showReadyNotification();
        }
      }
    })
    .catch(err => console.error('Status error:', err));
}

function updateStatusUI(order) {
  const sb = document.getElementById('statusBox');
  const pw = document.getElementById('progressWrap');
  const pb = document.getElementById('orderProgress');
  const ev = document.getElementById('etaValue');
  const st = document.getElementById('statusText');
  const od = document.getElementById('orderIdDisplay');
  
  pw?.classList.remove('d-none');
  if(st) st.innerText = order.status_label || order.status;
  if(sb) sb.className = `status-box ${order.status.toLowerCase()}`;
  if(od) od.innerHTML = `<i class="fas fa-hashtag"></i> Order #${order.id}`;
  
  const pm = {Pending:25, Preparing:65, Ready:100, Served:100, Cancelled:0};
  if(pb) pb.style.width = `${pm[order.status]||0}%`;
  
  const cm = {Pending:'bg-warning', Preparing:'bg-info', Ready:'bg-success', Served:'bg-secondary', Cancelled:'bg-danger'};
  if(pb) pb.className = `progress-bar ${cm[order.status]||'bg-secondary'} progress-bar-striped progress-bar-animated`;
  
  if(ev) {
    ev.innerText = order.estimated_ready || '--:--';
    if(order.prep_time) ev.innerHTML += ` <small>(~${order.prep_time}m)</small>`;
  }
}

function showReadyNotification() {
  Swal.fire({
    icon:'success',
    title:'🎉 Ready!',
    html:`<p>Table #${tableNo}</p><small>Collect from counter</small>`,
    timer:5000,
    showConfirmButton:false,
    background:'#1e1e2e',
    color:'#fff'
  });
}

function startStatusCheck(oid) {
  stopStatusCheck();
  checkOrderStatus(oid);
  statusInterval = setInterval(() => checkOrderStatus(oid), 15000);
}

function stopStatusCheck() {
  if(statusInterval) {
    clearInterval(statusInterval);
    statusInterval = null;
  }
}

// Initial load
if(typeof loadMenu === 'function') loadMenu();