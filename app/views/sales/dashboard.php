<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sales · Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --bg:#0b1220;         /* fallback bg if image missing */
      --card:#ffffff;
      --text:#0f172a;
      --muted:#6b7280;
      --accent:#7c3aed;     /* purple */
      --accent-2:#2563eb;   /* blue */
      --border:#e5e7eb;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Helvetica Neue",Arial,sans-serif;
      color:var(--text);
      /* Background image */
      background: var(--bg) no-repeat center/cover fixed;
      position:relative;
    }
    body::before{
      content:"";
      position:fixed; inset:0;
      background:
        linear-gradient(to bottom right, rgba(12,18,32,.85), rgba(12,18,32,.6)),
        url('assets/img/sales-bg.jpg') center/cover no-repeat fixed;
      filter: none;  
      z-index:-1;
    }

    .wrap{
      min-height:100%;
      display:flex; flex-direction:column;
    }

    header{
      padding:22px 22px 10px;
      color:#e5e7eb;
      display:flex; justify-content:space-between; align-items:center;
    }
    .title{font-weight:800; font-size:28px; letter-spacing:.3px}
    .right a{color:#e5e7eb; text-decoration:none; opacity:.9}
    .right a:hover{opacity:1}

    .content{
      flex:1;
      display:flex; align-items:center; justify-content:center;
      padding:24px;
    }
    .cards{
      display:grid;
      gap:24px;
      grid-template-columns:repeat(auto-fit,minmax(280px,320px));
      width:100%;
      max-width:700px;         
      justify-content:center;  
    }
    .card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:16px;
      padding:18px 18px 16px;
      box-shadow:0 10px 25px rgba(0,0,0,.18);
      backdrop-filter: blur(2px);
    }
    .card h3{margin:0 0 6px; font-size:18px}
    .card p{margin:0; color:var(--muted)}
    .actions{margin-top:14px; display:flex; gap:10px; flex-wrap:wrap}
    .btn{
      display:inline-flex; align-items:center; gap:8px;
      padding:10px 14px; border-radius:10px; cursor:pointer;
      border:1px solid transparent; text-decoration:none; font-weight:600;
      box-shadow:0 2px 0 rgba(0,0,0,.05);
    }
    .btn.primary{background:var(--accent); color:#fff}
    .btn.primary:hover{filter:brightness(1.05)}
    .btn.soft{background:#eef2ff; color:#3730a3; border-color:#c7d2fe}
    .btn.soft:hover{filter:brightness(1.02)}
    .row{display:flex; gap:10px; flex-wrap:wrap}

    footer{
      padding:16px 22px; color:#cbd5e1; display:flex; justify-content:space-between; align-items:center;
    }
    .logout{color:#e5e7eb; text-decoration:none; border:1px solid rgba(255,255,255,.3);
      padding:8px 12px; border-radius:10px; }
    .logout:hover{background:rgba(255,255,255,.08)}
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div class="title">Sales · Dashboard</div>
      <div class="right"><a href="index.php?route=sales/logout">Logout</a></div>
    </header>

    <div class="content">
      <div class="cards">
        <div class="card">
          <h3>Manage Test Drives</h3>
          <p>Approve, complete, or cancel customer test-drive requests.</p>
          <div class="actions">
            <a class="btn primary" href="index.php?route=sales/testdrives">Open</a>
            <a class="btn soft" href="index.php?route=sales/testdrives">View Schedule</a>
          </div>
        </div>

        <div class="card">
          <h3>Manage Reservations</h3>
          <p>Confirm or cancel reservations and monitor holds.</p>
          <div class="actions">
            <a class="btn primary" href="index.php?route=sales/reservations">Open</a>
            <a class="btn soft" href="index.php?route=sales/reservations">Pending List</a>
          </div>
        </div>
      </div>
    </div>

    <!--<footer>
      <div>© CarDealer</div>
      <a class="logout" href="index.php?route=sales/logout">Logout</a>
    </footer>-->
  </div>
</body>
</html>
