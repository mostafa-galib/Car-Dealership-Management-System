<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sales Executive Login · CarDealer</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <style>
    /* Page */
    html,body{height:100%}
    body{
      margin:0; font-family:sans-serif;
      background:#111827; color:#e5e7eb;
      display:flex; align-items:center; justify-content:center;
    }

    /* Card */
    .card{
      width:100%; max-width:400px;
      background:#1f2937; border:1px solid #374151; border-radius:12px;
      padding:30px; box-shadow:0 6px 20px rgba(0,0,0,.6);
    }
    h2{margin:0 0 20px; font-size:24px; font-weight:700; text-align:center; color:#f9fafb}

    /* Fields */
    .field{margin-bottom:14px}
    .field label{display:block; font-weight:600; font-size:14px; color:#d1d5db; margin-bottom:6px}
    .input{
      width:100%; height:42px; padding:0 12px; font-size:14px;
      background:#111827; color:#f9fafb; border:1px solid #4b5563; border-radius:8px;
    }
    .input::placeholder{color:#9ca3af}

    /* Remember line */
    .checkline{margin:10px 0 18px}
    .checkline label{
      display:flex; align-items:center; gap:8px;
      font-size:14px; font-weight:500; color:#d1d5db; margin:0;
      cursor:pointer; user-select:none;
    }
    .checkline input[type="checkbox"]{width:auto; margin:0}

    /* Button */
    .btn{
      width:100%; padding:12px; font-size:16px; font-weight:600; cursor:pointer;
      border:none; border-radius:8px; background:#059669; color:#fff;  /* green */
      transition:background .2s;
    }
    .btn:hover{background:#047857}

    /* Error */
    .error{
      margin-bottom:12px; font-size:14px;
      color:#f87171; background:#7f1d1d; border:1px solid #b91c1c; border-radius:6px; padding:8px 10px;
    }
    .foot{margin-top:10px; font-size:13px; text-align:center; color:#9ca3af}
  </style>
</head>
<body>
  <div class="card">
    <h2>Sales Executive Login</h2>

    <?php if(!empty($error)): ?>
      <div class="error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?route=sales/login_post">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">

      <div class="field">
        <label for="email">Email</label>
        <input class="input" id="email" type="email" name="email" placeholder="sales@example.com" required>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" placeholder="Your password" required>
      </div>

      <div class="checkline">
        <label for="remember">
          <input type="checkbox" id="remember" name="remember">
          <span>Remember me</span>
        </label>
      </div>

      <button class="btn" type="submit">Login</button>
    </form>

    <div class="foot">For sales executives only 📊</div>
  </div>
</body>
</html>
