let cart = [];

 let menu = [
 {name:"Burger", price:120, prep:10, image:"images/burger.jpg", category:"Burger"},

 {name:"Pizza", price:250, prep:15, image:"images/pizza.jpg", category:"Italian"},

 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg", category:"Italian"},

 {name:"Biriyani", price:180, prep:12, image:"images/biriyani.jpg", category:"Rice"},

 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"},
 {name:"Pasta", price:180, prep:12, image:"images/pasta.jpg"}
];

function loadMenu(){
  let html="";
  menu.forEach((item,index)=>{
    html += `
    <div class="col-md-4 mb-4 fade-in">
      <div class="glass-card text-center">
        <img src="${item.image}" class="img-fluid mb-3">
        <h5>${item.name}</h5>
        <p>₹ ${item.price}</p>

        <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
          <button class="btn btn-sm btn-danger" onclick="changeQty(${index},-1)">-</button>
          <span id="qty-${index}">0</span>
          <button class="btn btn-sm btn-success" onclick="changeQty(${index},1)">+</button>
        </div>
      </div>
    </div>`;
  });

  document.getElementById("menuItems").innerHTML = html;
}

function addToCart(item,price,prep){
  cart.push({item,price,prep});
  updateCartUI();
}

function updateCartUI(){
  document.getElementById("count").innerText = cart.length;

  let total = cart.reduce((s,c)=>s+c.price,0);
  document.getElementById("liveTotal").innerText = total;
  document.getElementById("drawerTotal").innerText = total;

  let html="";
  cart.forEach(c=>{
    html += `
      <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
        <span>${c.item}</span>
        <span>₹${c.price}</span>
      </div>`;
  });

  document.getElementById("cartItems").innerHTML = html || "Cart Empty";
}

function openCart(){
  document.getElementById("cartDrawer").classList.add("active");
}

function closeCart(){
  document.getElementById("cartDrawer").classList.remove("active");
}

function placeOrder(){
  if(cart.length === 0){
    alert("Cart empty");
    return;
  }

  let items = cart.map(c=>c.item).join(",");
  let total = cart.reduce((s,c)=>s+c.price,0);
  let prep_time = cart.reduce((s,c)=>s+c.prep,0);

  let form = new FormData();
  form.append("table_no", tableNo);
  form.append("items", items);
  form.append("total", total);
  form.append("prep_time", prep_time);

  fetch("place_order.php", { method:"POST", body:form })
    .then(res=>res.text())
    .then(orderId=>{
      if(orderId !== "error"){
        localStorage.setItem("order_id", orderId);
        Swal.fire({
          title: "Order Confirmed!",
          html: `Total: ₹${total}<br>Table: ${tableNo}`,
          icon: "success",
          confirmButtonColor: "#ff5722"
        });
        cart=[];
        updateCartUI();
        checkOrderStatus();
      }
    });
}

// 🔔 NEED ASSISTANCE (FIXED)
function callAssistance(){
  fetch("/restaurant_app/user/assistance.php?table=" + tableNo)
    .then(res => res.text())
    .then(() => {
      // 🔊 Voice Alert (works after user interaction)
      if ('speechSynthesis' in window) {
        const msg = new SpeechSynthesisUtterance("Staff is on the way");
        msg.lang = "en-IN";   // Indian English
        msg.rate = 1;        // speed
        msg.pitch = 1;       // pitch
        window.speechSynthesis.cancel(); // stop any previous
        window.speechSynthesis.speak(msg);
      }

      Swal.fire({
        icon: 'success',
        title: 'Assistance Requested!',
        text: 'Staff is on the way 🚶‍♂️',
        timer: 2000,
        showConfirmButton: false
      });
    })
    .catch(() => {
      Swal.fire({
        icon: 'error',
        title: 'Failed',
        text: 'Please try again',
      });
    });
}
function checkOrderStatus(){
  let id = localStorage.getItem("order_id");
  if(!id) return;

  fetch("order_status.php?id="+id)
    .then(res=>res.text())
    .then(status=>{
      let box = document.getElementById("statusBox");

      if(status=="Pending") box.innerHTML="🕒 Order Received";
      else if(status=="Preparing") box.innerHTML="👨‍🍳 Preparing";
      else if(status=="Served"){
        box.innerHTML="✅ Served";
        localStorage.removeItem("order_id");
      }
    });
}

function searchItem(){
  let input = document.getElementById("searchFood").value.toLowerCase();
  document.querySelectorAll(".glass-card").forEach((card,idx)=>{
    let title = card.querySelector("h5").innerText.toLowerCase();
    let parentCol = card.closest(".col-md-4");
    parentCol.style.display = title.includes(input) ? "block" : "none";
  });
}

function filterCategory(cat){
  document.querySelectorAll(".glass-card").forEach((card,idx)=>{
    let parentCol = card.closest(".col-md-4");
    if(cat==="all" || menu[idx].category===cat) parentCol.style.display="block";
    else parentCol.style.display="none";
  });
}

function changeQty(index,change){
  let qtySpan = document.getElementById("qty-"+index);
  let qty = parseInt(qtySpan.innerText) + change;
  if(qty < 0) qty = 0;
  qtySpan.innerText = qty;

  if(change > 0){
    addToCart(menu[index].name, menu[index].price, menu[index].prep);
  }
}

function toggleDark(){
  document.body.classList.toggle("dark-mode");
}

// 🔁 Init
loadMenu();
setInterval(checkOrderStatus, 5000);