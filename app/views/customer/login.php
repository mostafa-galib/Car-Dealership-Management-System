<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Customer Login · CarDealer</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background: #111827; /* deep black */
      color: #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .card {
      background: #1f2937; /* dark gray */
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
      display: block;
      color: #d1d5db;
    }
    input[type="email"], input[type="password"] {
      width: 94%;
      padding: 10px 12px;
      border: 1px solid #4b5563;
      border-radius: 8px;
      margin-bottom: 14px;
      font-size: 14px;
      background: #111827;
      color: #f9fafb;
    }
    input[type="email"]::placeholder, input[type="password"]::placeholder {
      color: #9ca3af;
    }
    .remember {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 10px 0 18px;
      font-size: 14px;
      color: #d1d5db;
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
      background: #2563eb;
      color: #fff;
      transition: background 0.2s;
    }
    .btn.primary:hover {
      background: #1d4ed8;
    }
    .footer {
      margin-top: 14px;
      font-size: 14px;
      text-align: center;
      color: #9ca3af;
    }
    .footer a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 600;
    }
    .footer a:hover {
      text-decoration: underline;
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
  </style>
</head>
<body>
  <div class="card">
    <h2>Customer Login</h2>

    <?php if(!empty($error)): ?>
      <div class="error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?route=customer/login_post">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">

      <label>Email</label>
      <input type="email" name="email" placeholder="email@example.com" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <div class="remember">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember" style="margin:0;font-weight:400;">Remember me</label>
      </div>

      <button class="btn primary">Login</button>
    </form>

    <div class="footer">
      New here? <a href="index.php?route=customer/register">Create an account</a>
    </div>
  </div>
</body>
</html>
