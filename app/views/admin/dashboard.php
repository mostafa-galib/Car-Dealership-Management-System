<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin · Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --bg:#0a0f1e;           /* fallback if image missing */
      --card:#ffffff;
      --text:#0f172a;
      --muted:#64748b;
      --accent:#16a34a;       /* green */
      --accent-2:#0ea5e9;     /* blue */
      --border:#e5e7eb;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,"Helvetica Neue",Arial,sans-serif;
      color:var(--text);
      background:var(--bg) no-repeat center/cover fixed;
      position:relative;
    }
  
    body::before{
      content:"";
      position:fixed; inset:0;
      background:
        linear-gradient(120deg, rgba(7,12,24,.86), rgba(7,12,24,.62)),
        url('assets/img/admin-bg.jpg') center/cover no-repeat fixed;
      z-index:-1;
    }

    .wrap{min-height:100%; display:flex; flex-direction:column}

    header{
      padding:22px 22px 10px; color:#e5e7eb;
      display:flex; justify-content:space-between; align-items:center;
    }
    .title{font-weight:800; font-size:28px; letter-spacing:.3px}
    .sub{font-size:13px; color:#cbd5e1; margin-top:2px}
    .right a{color:#e5e7eb; text-decoration:none; opacity:.9}
    .right a:hover{opacity:1}

    .content{
      flex:1; display:flex; align-items:center; justify-content:center; padding:24px;
    }
    .cards{
      display:grid; gap:24px;
      grid-template-columns:repeat(auto-fit,minmax(280px,320px));
      width:100%; max-width:700px; justify-content:center;
    }
    .card{
      background:var(--card); border:1px solid var(--border); border-radius:16px;
      padding:18px; box-shadow:0 10px 25px rgba(0,0,0,.18); backdrop-filter: blur(2px);
    }
    .card h3{margin:0 0 6px; font-size:18px}
    .card p{margin:0; color:var(--muted)}
    .actions{margin-top:14px; display:flex; gap:10px; flex-wrap:wrap}
    .btn{
      display:inline-flex; align-items:center; gap:8px;
      padding:10px 14px; border-radius:10px; cursor:pointer;
      border:1px solid transparent; text-decoration:none; font-weight:600;
      box-shadow:0 2px 0 rgba(0,0,0,.05);
      color:#0f172a;
    }
    .btn.primary{background:var(--accent); color:#fff; border-color:var(--accent)}
    .btn.primary:hover{filter:brightness(1.05)}
    .btn.soft{background:#e0f2fe; color:#075985; border-color:#bae6fd}
    .btn.soft:hover{filter:brightness(1.02)}

    footer{
      padding:16px 22px; color:#cbd5e1; display:flex; justify-content:space-between; align-items:center;
    }
    .logout{color:#e5e7eb; text-decoration:none; border:1px solid rgba(255,255,255,.3);
      padding:8px 12px; border-radius:10px;}
    .logout:hover{background:rgba(255,255,255,.08)}

    @media (max-width:700px){
      .title{font-size:24px}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <header>
      <div>
        <div class="title">Admin · Dashboard</div>
        <div class="sub">Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></div>
      </div>
      <div class="right">
        <a href="index.php?route=admin/logout">Logout</a>
      </div>
    </header>

    <div class="content">
      <div class="cards">
        <div class="card">
          <h3>Manage Cars</h3>
          <p>Add, edit, price, and upload images for inventory.</p>
          <div class="actions">
            <a class="btn primary" href="index.php?route=admin/cars">Open</a>
            <a class="btn soft" href="index.php?route=admin/cars">View Inventory</a>
          </div>
        </div>

        <div class="card">
          <h3>System Settings</h3>
          <p>Reservation hold time, tax rates, and defaults.</p>
          <div class="actions">
            <a class="btn primary" href="index.php?route=admin/settings">Open</a>
            <a class="btn soft" href="index.php?route=admin/settings">Quick Edit</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
</html>
