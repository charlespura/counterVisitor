<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website with Online Visitor Counter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Your original styles --- */
        * {margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
        body {background:linear-gradient(135deg,#6a11cb 0%,#2575fc 100%); color:#333; min-height:100vh; display:flex; flex-direction:column; align-items:center; padding:20px;}
        .container {max-width:900px; width:100%; background-color:rgba(255,255,255,0.95); border-radius:20px; box-shadow:0 15px 35px rgba(0,0,0,0.2); padding:40px; margin-top:30px;}
        header {text-align:center; margin-bottom:40px;}
        h1 {color:#2c3e50; margin-bottom:15px; font-size:2.8rem; background:linear-gradient(to right,#6a11cb,#2575fc); -webkit-background-clip:text; background-clip:text; color:transparent;}
        .subtitle {color:#7f8c8d; font-size:1.2rem; max-width:700px; margin:0 auto 30px;}
        .counter-container {background:linear-gradient(145deg,#ffffff,#f0f0f0); border-radius:15px; padding:30px; text-align:center; box-shadow:0 10px 20px rgba(0,0,0,0.1); margin-bottom:40px; border:1px solid #e0e0e0; transition:transform 0.3s ease;}
        .counter-container:hover {transform:translateY(-5px);}
        .counter-label {font-size:1.4rem; color:#7f8c8d; margin-bottom:15px; display:flex; align-items:center; justify-content:center; gap:10px;}
        .counter-value {font-size:5rem; font-weight:800; color:#2c3e50; text-shadow:2px 2px 4px rgba(0,0,0,0.1); margin:10px 0; font-family:'Courier New', monospace;}
        .counter-details {display:flex; justify-content:space-around; margin-top:25px; flex-wrap:wrap; gap:20px;}
        .detail-box {background-color:#f8f9fa; border-radius:10px; padding:15px; min-width:180px; box-shadow:0 5px 15px rgba(0,0,0,0.05);}
        .detail-label {font-size:0.9rem; color:#7f8c8d; margin-bottom:5px;}
        .detail-value {font-size:1.8rem; font-weight:700; color:#2c3e50;}
        .content {margin-top:40px; line-height:1.7; font-size:1.1rem; color:#444;}
        .content h2 {color:#2c3e50; margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid #eee;}
        .content p {margin-bottom:20px;}
        .features {display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px; margin-top:30px;}
        .feature {background-color:#f8f9fa; border-radius:10px; padding:20px; box-shadow:0 5px 15px rgba(0,0,0,0.05); transition:transform 0.3s ease;}
        .feature:hover {transform:translateY(-5px);}
        .feature i {font-size:2rem; color:#6a11cb; margin-bottom:15px;}
        .feature h3 {color:#2c3e50; margin-bottom:10px;}
        footer {margin-top:50px; text-align:center; color:rgba(255,255,255,0.8); font-size:0.9rem; padding:20px; width:100%;}
        .buttons {display:flex; gap:15px; justify-content:center; margin-top:30px;}
        button {background:linear-gradient(to right,#6a11cb,#2575fc); color:white; border:none; padding:12px 25px; border-radius:50px; font-size:1rem; font-weight:600; cursor:pointer; transition:all 0.3s ease; box-shadow:0 5px 15px rgba(106,17,203,0.3);}
        button:hover {transform:translateY(-3px); box-shadow:0 8px 20px rgba(106,17,203,0.4);}
        button.reset {background:linear-gradient(to right,#ff416c,#ff4b2b); box-shadow:0 5px 15px rgba(255,65,108,0.3);}
        button.reset:hover {box-shadow:0 8px 20px rgba(255,65,108,0.4);}
        @media (max-width:768px){.container{padding:25px;} h1{font-size:2.2rem;} .counter-value{font-size:4rem;} .counter-details{flex-direction:column; align-items:center;}}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-eye"></i> Visitor Counter</h1>
            <p class="subtitle">This page displays a live counter of how many times it has been viewed globally. Each visit increases the counter.</p>
        </header>
        
        <main>
            <div class="counter-container">
                <div class="counter-label">
                    <i class="fas fa-users"></i> Total Page Views
                </div>
                <div class="counter-value" id="counter">0</div>
                <div class="counter-details">
                    <div class="detail-box">
                        <div class="detail-label">Today's Views</div>
                        <div class="detail-value" id="todayCounter">0</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-label">Last Visit</div>
                        <div class="detail-value" id="lastVisit">Never</div>
                    </div>
                </div>
                
                <div class="buttons">
                    <button id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh Counter</button>
                    <button id="resetBtn" class="reset"><i class="fas fa-trash-alt"></i> Reset Counter</button>
                </div>
            </div>
            
            <div class="content">
                <h2>How This Visitor Counter Works</h2>
                <p>This counter tracks all visitors globally using Firebase Firestore and PHP. Each visit updates the database.</p>
            </div>
        </main>
    </div>
    
    <footer>
        <p>Visitor Counter &copy; 2023 | Page views: <span id="footerCounter">0</span></p>
    </footer>

    <script>
        async function updateCounter() {
            const res = await fetch('visitor.php');
            const data = await res.json();

            document.getElementById('counter').textContent = data.totalViews.toLocaleString();
            document.getElementById('todayCounter').textContent = data.todayViews.toLocaleString();
            document.getElementById('lastVisit').textContent = data.lastVisit;
            document.getElementById('footerCounter').textContent = data.totalViews.toLocaleString();
        }

        // Refresh button
        document.getElementById('refreshBtn').addEventListener('click', updateCounter);

        // Reset button
        document.getElementById('resetBtn').addEventListener('click', async () => {
            if(confirm("Are you sure you want to reset the counter?")) {
                await fetch('visitor.php?reset=true');
                updateCounter();
            }
        });

        // Load counter on page load
        window.addEventListener('load', updateCounter);
    </script>
</body>
</html>
