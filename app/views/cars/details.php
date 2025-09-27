<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($car['brand'].' '.$car['model']) ?> · CarDealer</title>
<link rel="stylesheet" href="assets/css/app.css">
<style>
  :root{
    --bg:#fff; --card:#fff; --text:#111; --muted:#555; --border:#e5e7eb; --primary:#007bff;
  }
  body{margin:0;font-family:sans-serif;background:var(--bg);color:var(--text)}
  .container{display:flex;min-height:100vh}
  .sidebar{width:220px;background:#222;color:#fff;padding:20px}
  .main{flex:1;display:flex;flex-direction:column}
  .header{padding:16px;border-bottom:1px solid #ccc;display:flex;justify-content:space-between;align-items:center;background:var(--card)}
  .content{padding:20px}
  .row{display:flex;gap:12px;flex-wrap:wrap}
  .card{border:1px solid var(--border);border-radius:12px;background:var(--card)}
  .specs{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:8px}
  .spec{padding:10px;border:1px solid var(--border);border-radius:8px;background:#fafafa}
  .badge{display:inline-block;padding:4px 10px;border:1px solid var(--border);border-radius:999px;font-size:12px;color:#333;background:#fafafa}
  .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 14px;border:1px solid #111;border-radius:8px;text-decoration:none;background:#f7f7f7;cursor:pointer}
  .btn.primary{background:var(--primary);color:#fff;border-color:var(--primary)}
  .btn:focus{outline:3px solid rgba(0,123,255,.25)}
  /* ---------- Inputs (pretty) ---------- */
  .form-inline{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap}
  .control{display:flex;flex-direction:column;gap:6px;min-width:180px}
  .label{font-size:12px;color:var(--muted)}
  .input{
    height:40px;padding:0 12px;border:1px solid var(--border);
    border-radius:8px;background:#fff;font-size:14px;
    transition:box-shadow .15s,border-color .15s;
  }
  .input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(0,123,255,.15);outline:none}
  .input::-webkit-calendar-picker-indicator{filter:opacity(.65)}
  .helper{font-size:12px;color:var(--muted)}
  /* Thumbnail strip */
  .thumb{width:120px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--border)}
  /* Responsive */
  @media (max-width:900px){
    .sidebar{display:none}
  }
</style>
</head>
<body>
<div class="container">
  <aside class="sidebar"><?php include __DIR__."/../partials/sidebar.php"; ?></aside>

  <main class="main">
    <header class="header">
      <div class="title">Car Details</div>
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
      <nav style="margin-bottom:12px;color:#555">
        Cars › <?= htmlspecialchars($car['brand'].' '.$car['model']) ?>
      </nav>

      <div class="row">
        <div style="flex:2;min-width:300px">
          <div class="card">
            <img src="<?= htmlspecialchars($cover) ?>" style="width:100%;height:360px;object-fit:cover;border-radius:12px 12px 0 0" alt="">
          </div>
          <div class="row" style="margin-top:10px">
            <?php while($img = $gallery->fetch_assoc()): ?>
              <img src="<?= htmlspecialchars($img['image_path']) ?>" class="thumb" alt="">
            <?php endwhile; ?>
          </div>
        </div>

        <div style="flex:1;min-width:280px">
          <div class="card" style="padding:16px">
            <div style="font-size:22px;font-weight:700">
              <?= htmlspecialchars($car['brand'].' '.$car['model'].($car['variant']?' · '.$car['variant']:'')) ?>
            </div>
            <div style="font-size:20px;color:var(--primary);font-weight:700;margin-top:2px">
              $<?= number_format((float)$car['asking_price'],2) ?>
            </div>

            <div class="row" style="margin:12px 0 6px">
              <a class="btn" href="index.php?route=cars/compare&ids=<?= (int)$car['id'] ?>">Compare</a>
            </div>

            <!-- Actions (styled inputs) -->
            <div class="row" style="gap:12px;align-items:flex-start;margin-top:6px">
              <!-- Test Drive -->
              <form method="post" action="index.php?route=testdrives/store" class="card" style="padding:14px;flex:1;min-width:260px">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="unit_id" value="<?= (int)$car['id'] ?>">
                <div class="control">
                  <label class="label">Preferred Date & Time</label>
                  <input class="input" type="datetime-local" name="preferred_datetime" id="td-dt" required>
                  <div class="helper">Pick any future slot</div>
                </div>
                <div style="margin-top:10px">
                  <button class="btn primary" type="submit">Request Test Drive</button>
                </div>
              </form>

              <!-- Reservation -->
              <form method="post" action="index.php?route=reservations/store" class="card" style="padding:14px;flex:1;min-width:260px">
                <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="unit_id" value="<?= (int)$car['id'] ?>">
                <input type="hidden" name="reservation_type" value="purchase_hold">
                <div class="control">
                  <label class="label">Booking Amount (USD)</label>
                  <input class="input" type="number" name="booking_amount" min="0" step="0.01" placeholder="e.g., 500.00" required>
                  <div class="helper">Fully refundable until confirmation</div>
                </div>
                <div style="margin-top:10px">
                  <button class="btn" type="submit">Reserve Car</button>
                </div>
              </form>
            </div>

            <div class="row" style="margin-top:12px">
              <?php if (!empty($car['fuel_type'])): ?><span class="badge">⛽ <?= htmlspecialchars($car['fuel_type']) ?></span><?php endif; ?>
              <?php if (!empty($car['transmission'])): ?><span class="badge">⚙️ <?= htmlspecialchars($car['transmission']) ?></span><?php endif; ?>
              <?php if (!empty($car['year'])): ?><span class="badge">📅 <?= (int)$car['year'] ?></span><?php endif; ?>
            </div>
          </div>

          <div class="card" style="padding:16px;margin-top:16px">
            <h3 style="margin:0 0 8px">Description</h3>
            <p style="color:#555;margin:0">
              <?= htmlspecialchars($car['description'] ?? 'No description available.') ?>
            </p>
          </div>
        </div>
      </div>

      <h3 style="margin:20px 0 10px">Specifications</h3>
      <div class="specs">
        <div class="spec"><span>Fuel: </span><b><?= htmlspecialchars($car['fuel_type'] ?? '—') ?></b></div>
        <div class="spec"><span>Transmission: </span><b><?= htmlspecialchars($car['transmission'] ?? '—') ?></b></div>
        <div class="spec"><span>Engine: </span><b><?= htmlspecialchars(isset($car['engine_cc']) && $car['engine_cc']!==null ? $car['engine_cc'].' cc' : '—') ?></b></div>
        <div class="spec"><span>Power: </span><b><?= htmlspecialchars(isset($car['power_hp']) && $car['power_hp']!==null ? $car['power_hp'].' hp' : '—') ?></b></div>
        <div class="spec"><span>Mileage: </span><b><?= htmlspecialchars(isset($car['mileage_kmpl']) && $car['mileage_kmpl']!==null ? $car['mileage_kmpl'].' km/l' : '—') ?></b></div>
        <div class="spec"><span>Seating: </span><b><?= htmlspecialchars(isset($car['seats']) && $car['seats']!==null ? $car['seats'] : '—') ?></b></div>
        <div class="spec"><span>Airbags: </span><b><?= htmlspecialchars(isset($car['airbags']) && $car['airbags']!==null ? $car['airbags'] : '—') ?></b></div>
        <div class="spec"><span>Color: </span><b><?= htmlspecialchars($car['color'] ?? '—') ?></b></div>
      </div>
    </div>

    <div class="footer" style="padding:12px;border-top:1px solid #ccc;text-align:center;color:#777">
      © CarDealer
    </div>
  </main>
</div>

<script>
// optional: set minimum datetime to now+1 hour for nicer UX
(function(){
  const el = document.getElementById('td-dt');
  if(!el) return;
  const pad = n => String(n).padStart(2,'0');
  const d = new Date(Date.now() + 60*60*1000); // +1h
  const iso = d.getFullYear()+'-'+pad(d.getMonth()+1)+'-'+pad(d.getDate())
            +'T'+pad(d.getHours())+':'+pad(d.getMinutes());
  el.min = iso;
})();
</script>
</body>
</html>
