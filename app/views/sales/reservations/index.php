<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login · CarDealer</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background: #111827; /* dark background */
      color: #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .card {
      background: #1f2937; /* dark gray card */
      border: 1px solid #374151;
      border-radius: 12px;
      padding: 30px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.6);
    }
    h2 {
      margin: 0 0 20px;
      font-size: 24px;
      font-weight: 700;
      text-align: center;
      color: #f9fafb;
    }
    label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 6px;
      color: #d1d5db;
    }
    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #4b5563;
      border-radius: 8px;
      margin-bottom: 14px;
      font-size: 14px;
      background: #111827;
      color: #f9fafb;
    }
    input::placeholder {
      color: #9ca3af;
    }
    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    .btn.primary {
      background: #dc2626; /* red for admin */
      color: #fff;
      transition: background 0.2s;
    }
    .btn.primary:hover {
      background: #b91c1c;
    }
    .checkbox-group {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 14px;
      font-size: 14px;
      color: #d1d5db;
    }
    .checkbox-group input {
      margin: 0;
      width: auto;
    }
    .checkbox-group label {
      display: inline; /* force inline for checkbox text */
      margin: 0;
      font-weight: normal;
    }
    .error {
      color: #f87171;
      background: #7f1d1d;
      padding: 8px 10px;
      border: 1px solid #b91c1c;
      border-radius: 6px;
      margin-bottom: 12px;
      font-size: 14px;
    }
    .footer {
      margin-top: 14px;
      font-size: 13px;
      text-align: center;
      color: #9ca3af;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Admin Login</h2>

    <?php if(!empty($error)): ?>
      <div class="error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?route=admin/login_post">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">

      <label>Email or Username</label>
      <input type="text" name="identity" placeholder="admin@example.com" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Your password" required>

      <div class="checkbox-group">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember me</label>
      </div>

      <button class="btn primary">Login</button>
    </form>

    <div class="footer">
      Admin access only 🔒
    </div>
  </div>
</body>
</html>
