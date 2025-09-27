<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><title>My Reservations</title>
<link rel="stylesheet" href="assets/css/app.css">
<style>
  body { margin:0; font-family:sans-serif; }
  .container { display:flex; min-height:100vh; }
  .sidebar { width:220px; background:#222; color:#fff; padding:20px; }
  .main { flex:1; display:flex; flex-direction:column; }
  .header { padding:16px; border-bottom:1px solid #ccc; display:flex; justify-content:space-between; align-items:center; }
  .content { flex:1; padding:20px; }
  .table { width:100%; border-collapse:collapse; }
  .table th, .table td { border:1px solid #ddd; padding:8px; }
  .btn{display:inline-block;padding:6px 10px;border:1px solid #333;border-radius:6px;background:#f7f7f7;text-decoration:none}
  .btn.danger{background:#dc3545;color:#fff;border-color:#dc3545}
  form{display:inline}
</style>
</head>
<body>
<div class="container">
  <aside class="sidebar"><?php include __DIR__."/../partials/sidebar.php"; ?></aside>
  <main class="main">
    <header class="header">
      <h2>My Reservations</h2>
      <div>
        <?php if (!empty($_SESSION['customer_id'])): ?>
          Hello, <?= htmlspecialchars($_SESSION['customer_name'] ?? 'Customer') ?> |
          <a href="index.php?route=customer/logout">Logout</a>
        <?php else: ?>
          <a href="index.php?route=customer/login">Login</a>
        <?php endif; ?>
      </div>
    </header>

    <div class="content">
      <table class="table">
        <thead>
          <tr>
            <th>#</th><th>Car</th><th>Type</th><th>Booking Amount</th>
            <th>Hold Expires</th><th>Status</th><th>Created</th><th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while($r = $rows->fetch_assoc()): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($r['brand'].' '.$r['model'].($r['variant']?' · '.$r['variant']:'')) ?> (<?= htmlspecialchars($r['color'] ?? '') ?>)</td>
              <td><?= htmlspecialchars($r['reservation_type']) ?></td>
              <td>$<?= number_format((float)$r['booking_amount'],2) ?></td>
              <td><?= htmlspecialchars($r['hold_expires_at'] ?? '—') ?></td>
              <td><?= htmlspecialchars($r['status']) ?></td>
              <td><?= htmlspecialchars($r['created_at'] ? date('Y-m-d', strtotime($r['created_at'])) : '—') ?></td>
              <td>
                <?php if ($r['status']==='pending'): ?>
                  <form method="post" action="index.php?route=reservations/cancel" onsubmit="return confirm('Cancel this reservation?');">
                    <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button class="btn danger" type="submit">Cancel</button>
                  </form>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <p><a href="index.php?route=cars">← Back to Cars</a></p>
    </div>
  </main>
</div>
</body>
</html>
