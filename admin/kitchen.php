<?php
session_start();
if(!isset($_SESSION['admin']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'kitchen'){
  header("Location: login.php");
  exit;
}
include("../config/db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kitchen Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin_style.css">
</head>

<body>

<div class="premium-layout">
  <div class="premium-sidebar">
    <h2>🍽 MK Admin</h2>
    <nav>
      <a href="dashboard.php">📊 Owner Dashboard</a>
      <a href="kitchen.php" class="active">👨‍🍳 Kitchen</a>
      <a href="qr.php">📱 QR Codes</a>
      <a href="logout.php">🚪 Logout</a>
    </nav>
  </div>

  <div class="premium-main">
    <div class="premium-top">
      <h4>👨‍🍳 Kitchen – Live Orders</h4>
      <div class="live-indicator">
        <span class="pulse-dot"></span> Kitchen Active
      </div>
    </div>

    <!-- 🔔 Assistance Panel -->
    <div class="assist-panel">
      <h5>🔔 Assistance Requests</h5>
      <div id="assistContainer"></div>
    </div>

    <!-- 📦 Orders -->
    <h5 class="mt-4">📦 Live Orders</h5>
    <div class="orders-grid" id="ordersContainer"></div>
  </div>
</div>

<script>
// 🔔 Backup sounds (optional)
const assistSound = new Audio("sounds/assist.mp3");
const orderSound  = new Audio("sounds/order.mp3");

// 🧠 Persistent memory (prevents repeat on refresh)
let spokenAssistIds = new Set(JSON.parse(localStorage.getItem("spokenAssistIds") || "[]"));
let spokenOrderIds  = new Set(JSON.parse(localStorage.getItem("spokenOrderIds") || "[]"));
let spokenReadyIds  = new Set(JSON.parse(localStorage.getItem("spokenReadyIds") || "[]"));

// 🎤 Stable voice helper (female for orders, male for assistance)
function safeSpeak(text, female=false){
  if (!('speechSynthesis' in window)) return;

  if (speechSynthesis.speaking) {
    setTimeout(() => safeSpeak(text, female), 800);
    return;
  }

  const voices = speechSynthesis.getVoices();
  let voice;

  if (female) {
    voice =
      voices.find(v => v.lang.startsWith("en") && (v.name.toLowerCase().includes("zira") || v.name.toLowerCase().includes("susan") || v.name.toLowerCase().includes("samantha"))) ||
      voices.find(v => v.lang.startsWith("en")) ||
      voices[0];
  } else {
    voice =
      voices.find(v => v.lang.startsWith("en") && v.name.toLowerCase().includes("google")) ||
      voices.find(v => v.lang.startsWith("en")) ||
      voices[0];
  }

  const msg = new SpeechSynthesisUtterance(text);
  msg.voice = voice;
  msg.lang = voice?.lang || "en-US";
  msg.rate = 0.9;
  msg.pitch = female ? 1.1 : 0.9;
  msg.volume = 1;

  speechSynthesis.speak(msg);
}

// 📦 Orders
function refreshOrders(){
  fetch("orders_partial.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("ordersContainer").innerHTML = html;

      const orderMatches = [...html.matchAll(/Order\s*#(\d+)/g)].map(m => m[1]);

      orderMatches.forEach(id => {
        // 🆕 New Order
        if(!spokenOrderIds.has(id)){
          const tableNo = getTableFromHtml(html, id);
          orderSound.play().catch(()=>{});
          safeSpeak(`New order received from table ${tableNo}`, true);

          spokenOrderIds.add(id);
          localStorage.setItem("spokenOrderIds", JSON.stringify([...spokenOrderIds]));
        }

        // ✅ Ready Order
        const status = getStatusFromHtml(html, id);
        if(status === "Completed" && !spokenReadyIds.has(id)){
          orderSound.play().catch(()=>{});
          safeSpeak(`Order number ${id} is ready to serve`, true);

          spokenReadyIds.add(id);
          localStorage.setItem("spokenReadyIds", JSON.stringify([...spokenReadyIds]));
        }
      });
    });
}

// 🔔 Assistance
function refreshAssistance(){
  fetch("/restaurant_app/user/assistance.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("assistContainer").innerHTML = html;

      const ids = [...html.matchAll(/name="id" value="(\d+)"/g)].map(m => m[1]);

      ids.forEach(id => {
        if(!spokenAssistIds.has(id)){
          const t = html.match(new RegExp(`Table\\s+(\\d+)[\\s\\S]*?name="id" value="${id}"`));
          const tableNo = t && t[1] ? t[1] : "unknown";

          assistSound.play().catch(()=>{});
          safeSpeak(`Attention. Table number ${tableNo} needs assistance.`, false);

          spokenAssistIds.add(id);
          localStorage.setItem("spokenAssistIds", JSON.stringify([...spokenAssistIds]));
        }
      });
    });
}

function getTableFromHtml(html, id){
  const m = html.match(new RegExp(`Order\\s*#${id}[\\s\\S]*?<p><strong>Table:</strong>\\s*(\\d+)`));
  return m && m[1] ? m[1] : "unknown";
}

function getStatusFromHtml(html, id){
  const m = html.match(new RegExp(`Order\\s*#${id}[\\s\\S]*?(Pending|Preparing|Completed)`));
  return m && m[1] ? m[1] : "";
}

// 🔁 Auto refresh
setInterval(()=>{
  refreshOrders();
  refreshAssistance();
}, 5000);

refreshOrders();
refreshAssistance();

// 🔓 Unlock audio once (browser policy)
document.body.addEventListener("click", function unlockOnce(){
  assistSound.play().catch(()=>{});
  document.body.removeEventListener("click", unlockOnce);
});
</script>

</body>
</html>