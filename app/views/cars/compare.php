<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Compare Cars · CarDealer</title>
<link rel="stylesheet" href="assets/css/app.css">
<style>
  body{margin:0;font-family:sans-serif}
  .container{display:flex;min-height:100vh}
  .sidebar{width:220px;background:#222;color:#fff;padding:20px}
  .main{flex:1;display:flex;flex-direction:column}
  .header{padding:16px;border-bottom:1px solid #ccc;display:flex;justify-content:space-between;align-items:center}
  .content{padding:20px}
  .row{display:flex;gap:12px}
  .card{border:1px solid #ddd;border-radius:10px;background:#fff;overflow:hidden}
  .car-body{padding:10px}
  .car-title{font-weight:600}
  .car-price{font-weight:700;margin-top:4px;color:#007bff}
  table{width:100%;border-collapse:collapse;margin-top:16px}
  th,td{border:1px solid #ddd;padding:8px;text-align:center}
  th{background:#f7f7f7}
</style>
</head>
<body>
<div class="container">
  <aside class="sidebar"><?php include __DIR__."/../partials/sidebar.php"; ?></aside>

  <main class="main">
    <header class="header">
      <div class="title">Compare Cars</div>
      <div>
        <?php if (!empty($_SESSION['customer_id'])): ?>
          Hello, <?= htmlspecialchars($_SESSION['customer_name'] ?? 'Customer') ?> |
          <a class="btn" href="index.php?route=customer/logout">Logout</a>
        <?php else: ?>
          <a class="btn" href="index.php?route=customer/login">Customer Login</a>
          <a class="btn" href="index.php?route=customer/register">Register</a>
        <?php endif; ?>
      </div>
    </header>

    <div class="content">
      <?php if (!$cars): ?>
        <p>No cars selected for comparison.</p>
      <?php else: ?>
        <div class="row">
          <?php foreach ($cars as $car): ?>
            <div class="card" style="flex:1">
              <img src="<?= htmlspecialchars($imgModel->cover($car['id'])) ?>" style="width:100%;height:180px;object-fit:cover" alt="">
              <div class="car-body">
                <div class="car-title"><?= htmlspecialchars($car['brand'].' '.$car['model'].($car['variant']?' · '.$car['variant']:'')) ?></div>
                <div class="car-price">$<?= number_format((float)$car['asking_price'],2) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <table>
          <thead>
          <tr>
            <th>Spec</th>
            <?php foreach ($cars as $c): ?>
              <th><?= htmlspecialchars($c['brand'].' '.$c['model']) ?></th>
            <?php endforeach; ?>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>Fuel</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars($c['fuel_type'] ?? '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Transmission</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars($c['transmission'] ?? '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Engine</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars(isset($c['engine_cc']) && $c['engine_cc']!==null ? $c['engine_cc'].' cc' : '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Power</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars(isset($c['power_hp']) && $c['power_hp']!==null ? $c['power_hp'].' hp' : '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Mileage</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars(isset($c['mileage_kmpl']) && $c['mileage_kmpl']!==null ? $c['mileage_kmpl'].' km/l' : '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Seating</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars(isset($c['seats']) && $c['seats']!==null ? $c['seats'] : '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Airbags</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars(isset($c['airbags']) && $c['airbags']!==null ? $c['airbags'] : '—') ?></td><?php endforeach; ?>
            </tr>
            <tr>
              <td>Color</td>
              <?php foreach ($cars as $c): ?><td><?= htmlspecialchars($c['color'] ?? '—') ?></td><?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="footer" style="padding:12px;border-top:1px solid #ccc;text-align:center;color:#777">
      © CarDealer
    </div>
  </main>
</div>
</body>
</html>
