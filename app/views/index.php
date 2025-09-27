<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Car Dealership System · Home</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <style>
    body { margin:0; font-family:sans-serif; }
    .container { display:flex; min-height:100vh; }
    .sidebar { width:220px; background:#222; color:#fff; padding:20px; }
    .sidebar .logo { font-size:22px; font-weight:bold; margin-bottom:20px; }
    .sidebar .nav a { display:block; padding:8px 0; color:#bbb; text-decoration:none; }
    .sidebar .nav a:hover { color:#fff; }
    .main { flex:1; display:flex; flex-direction:column; }
    .header { padding:16px; border-bottom:1px solid #ccc; display:flex; justify-content:space-between; align-items:center; }
    .content { flex:1; padding:20px; }
    .footer { padding:12px; border-top:1px solid #ccc; text-align:center; color:#777; }
    .btn { display:inline-block; padding:10px 16px; margin:6px; border:1px solid #333; border-radius:4px; text-decoration:none; }
    .btn.primary { background:#007bff; color:#fff; border:none; }
  </style>
</head>
<body>
<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">CarDealer</div>
    <nav class="nav">

      // All users can see
      <a href="index.php?route=cars">Cars</a>

      // Only visible after login
      <?php if (!empty($_SESSION['customer_id'])): ?>
        <a href="index.php?route=reservations/my">My Reservations</a>
        <a href="index.php?route=testdrives/my">My Test Drives</a>
      <?php endif; ?>

      // Only Sales Executive
      <?php if (!empty($_SESSION['sales_id'])): ?>
        <div style="margin:12px 0;border-top:1px solid #555"></div>
        <a href="index.php?route=sales/dashboard">Exec · Dashboard</a>
      <?php endif; ?>

      // Only Admin 
      <?php if (!empty($_SESSION['admin_id'])): ?>
        <div style="margin:12px 0;border-top:1px solid #555"></div>
        <a href="index.php?route=admin/overview">Admin · Overview</a>
      <?php endif; ?>
    </nav>
  </aside>

  <!-- Main -->
  <main class="main">
    <header class="header">
      <div class="title">Welcome</div>
      <div>
        <?php if (!empty($_SESSION['customer_id'])): ?>
          <span>Hello, <?= htmlspecialchars($_SESSION['customer_name'] ?? 'Customer') ?></span>
          <a class="btn" href="index.php?route=customer/logout">Logout</a>

        <?php elseif (!empty($_SESSION['sales_id'])): ?>
          <span>Exec: <?= htmlspecialchars($_SESSION['sales_name'] ?? '') ?></span>
          <a class="btn" href="index.php?route=sales/logout">Logout</a>

        <?php elseif (!empty($_SESSION['admin_id'])): ?>
          <span>Admin: <?= htmlspecialchars($_SESSION['admin_username'] ?? '') ?></span>
          <a class="btn" href="index.php?route=admin/logout">Logout</a>

        <?php else: ?>
          <a class="btn" href="index.php?route=customer/login">Customer Login</a>
          <a class="btn" href="index.php?route=sales/login">Sales Exec Login</a>
          <a class="btn" href="index.php?route=admin/login">Admin Login</a>
        <?php endif; ?>
      </div>
    </header>

    <div class="content">
      <h1>Welcome to Car Dealership Management System</h1>
      <p>Browse our collection of cars, compare models, request test drives, and reserve your dream ride!</p>

      <a class="btn primary" href="index.php?route=cars">🚗 Browse Cars</a>

      <?php if (empty($_SESSION['customer_id']) && empty($_SESSION['sales_id']) && empty($_SESSION['admin_id'])): ?>
        <a class="btn" href="index.php?route=customer/register">📝 Create Customer Account</a>
      <?php endif; ?>
    </div>

    <div class="footer">© <?= date("Y") ?> CarDealer</div>
  </main>
</div>
</body>
</html>
