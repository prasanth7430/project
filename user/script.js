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
        <div class="d-flex justify-content-center gap-2 mt-2">
          <button class="btn btn-sm btn-danger" onclick="changeQty(${index},-1)">-</button>
          <span id="qty-${index}">0</span>
          <button class="btn btn-sm btn-success" onclick="changeQty(${index},1)">+</button>
        </div>
      </div>
    </div>`;
  });
  document.getElementById("menuItems").innerHTML = html;
}

function changeQty(index,change){
  let qtySpan = document.getElementById("qty-"+index);
  let qty = parseInt(qtySpan.innerText || "0") + change;
  if(qty < 0) qty = 0;

  if(change > 0){
    cart.push({
      item: menu[index].name,
      price: Number(menu[index].price),
      prep: Number(menu[index].prep)
    });
  } else {
    let i = cart.findIndex(c => c.item === menu[index].name);
    if(i > -1) cart.splice(i,1);
  }

  qtySpan.innerText = qty;
  updateCartUI();
}

function updateCartUI(){
  document.getElementById("count").innerText = cart.length;

  let subtotal = cart.reduce((s,c)=> s + Number(c.price || 0), 0);
  let gst = Math.round(subtotal * 0.05);
  let service = Math.round(subtotal * 0.02);
  let grand = subtotal + gst + service;

  document.getElementById("liveTotal").innerText = grand;

  document.getElementById("billSubtotal").innerText = subtotal;
  document.getElementById("billGST").innerText = gst;
  document.getElementById("billService").innerText = service;
  document.getElementById("billGrand").innerText = grand;

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
  let subtotal = cart.reduce((s,c)=> s + Number(c.price || 0), 0);
  let gst = Math.round(subtotal * 0.05);
  let service = Math.round(subtotal * 0.02);
  let total = subtotal + gst + service;
  let prep_time = cart.reduce((s,c)=> s + Number(c.prep || 0), 0);

  let form = new FormData();
  form.append("table_no", tableNo);
  form.append("items", items);
  form.append("total", total);
  form.append("prep_time", prep_time);

  fetch("place_order.php", { method:"POST", body:form })
    .then(res=>res.text())
    .then(orderId=>{
      if(orderId !== "error"){
        Swal.fire({
          title: "Order Confirmed!",
          html: `Subtotal: ₹${subtotal}<br>GST: ₹${gst}<br>Service: ₹${service}<br><b>Total: ₹${total}</b>`,
          icon: "success"
        });
        cart=[];
        document.querySelectorAll("[id^='qty-']").forEach(e=>e.innerText=0);
        updateCartUI();
      } else {
        alert("Order failed ❌");
      }
    });
}

function toggleDark(){
  document.body.classList.toggle("dark-mode");
}

loadMenu();