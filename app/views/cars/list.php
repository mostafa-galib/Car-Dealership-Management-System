<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Cars · CarDealer</title>
<link rel="stylesheet" href="assets/css/app.css">
<style>
  body{margin:0;font-family:sans-serif}
  .container{display:flex;min-height:100vh}
  .sidebar{width:220px;background:#222;color:#fff;padding:20px}
  .main{flex:1;display:flex;flex-direction:column}
  .header{padding:16px;border-bottom:1px solid #ccc;display:flex;justify-content:space-between;align-items:center}
  .content{padding:20px}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px}
  .card{border:1px solid #ddd;border-radius:10px;overflow:hidden;background:#fff}
  .car-body{padding:10px}
  .car-title{font-weight:600}
  .car-price{font-weight:700;margin-top:4px;color:#007bff}
  .row{display:flex;gap:8px;flex-wrap:wrap}
  .btn{display:inline-block;padding:8px 12px;border:1px solid #333;border-radius:6px;text-decoration:none;background:#f7f7f7}
  .btn.primary{background:#007bff;color:#fff;border-color:#007bff}
  .filters .row>div{display:flex;gap:8px}
  input,select{padding:8px;border:1px solid #bbb;border-radius:6px}
</style>
</head>
<body>
<div class="container">
  <aside class="sidebar"><?php include __DIR__."/../partials/sidebar.php"; ?></aside>

  <main class="main">
    <header class="header">
      <div class="title">Cars</div>
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
      <!-- Filters -->
      <form class="card filters" method="get" action="index.php" style="padding:12px;margin-bottom:16px">
        <input type="hidden" name="route" value="cars">
        <div class="row">
          <div>
            <!-- brand field now searches brand OR model OR variant (controller->model handles) -->
            <input name="brand" placeholder="Brand / Model / Variant" value="<?= htmlspecialchars($_GET['brand'] ?? '') ?>">
            <select name="fuel">
              <option value="">Fuel</option>
              <?php foreach (['Petrol','Diesel','Hybrid','Electric'] as $f): ?>
              <option value="<?= $f ?>" <?= (($_GET['fuel'] ?? '')===$f)?'selected':'' ?>><?= $f ?></option>
              <?php endforeach; ?>
            </select>
            <select name="trans">
              <option value="">Transmission</option>
              <?php foreach (['Manual','Automatic','CVT','Other'] as $t): ?>
              <option value="<?= $t ?>" <?= (($_GET['trans'] ?? '')===$t)?'selected':'' ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <input name="pmin" placeholder="Min Price" value="<?= htmlspecialchars($_GET['pmin'] ?? '') ?>">
            <input name="pmax" placeholder="Max Price" value="<?= htmlspecialchars($_GET['pmax'] ?? '') ?>">
            <button class="btn">Filter</button>
            <a class="btn" href="index.php?route=cars">Reset</a>
            <a class="btn" href="index.php?route=cars/compare">Compare Page</a>
          </div>
        </div>
      </form>

      <!-- Cars Grid -->
      <div class="grid">
        <?php while($c = $cars->fetch_assoc()):
              // $imgModel comes from controller; don't use $conn here
              $cover = $imgModel->cover($c['id']);
        ?>
        <div class="card">
          <img src="<?= htmlspecialchars($cover) ?>" style="width:100%;height:160px;object-fit:cover" alt="">
          <div class="car-body">
            <div class="car-title">
              <?= htmlspecialchars($c['brand'].' '.$c['model'].($c['variant']?' · '.$c['variant']:'')) ?>
            </div>
            <div class="car-price">$<?= number_format((float)$c['asking_price'],2) ?></div>

            <div class="row" style="margin-top:8px">
              <a class="btn" href="index.php?route=cars/details&id=<?= (int)$c['id'] ?>">Details</a>

              <!-- Compare: opens compare selection with this car preselected -->
              <a class="btn" href="index.php?route=cars/compare&pref=<?= (int)$c['id'] ?>">Compare</a>

              <!-- Request Test Drive (login gate at route) -->
              <form method="post" action="index.php?route=testdrives/store" style="display:inline">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="unit_id" value="<?= (int)$c['id'] ?>">
                <input type="datetime-local" name="preferred_datetime" required>
                <button class="btn">Test Drive</button>
              </form>


              <!-- Reserve (login gate at route) -->
              <form method="post" action="index.php?route=reservations/store" style="display:inline">
                 <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                 <input type="hidden" name="unit_id" value="<?= (int)$c['id'] ?>">
                 <input type="hidden" name="reservation_type" value="purchase_hold">
                 <input type="number" name="booking_amount" placeholder="Booking $" min="0" step="0.01" required style="width:120px">
                 <button class="btn primary">Reserve</button>
              </form>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="footer" style="padding:12px;border-top:1px solid #ccc;text-align:center;color:#777">
      © CarDealer
    </div>
  </main>
</div>
</body>
</html>
