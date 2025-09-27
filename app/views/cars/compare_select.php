<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Compare · Select Cars · CarDealer</title>
<link rel="stylesheet" href="assets/css/app.css">
<style>
  body{margin:0;font-family:sans-serif}
  .container{display:flex;min-height:100vh}
  .sidebar{width:220px;background:#222;color:#fff;padding:20px}
  .main{flex:1;display:flex;flex-direction:column}
  .header{padding:16px;border-bottom:1px solid #ccc;display:flex;justify-content:space-between;align-items:center}
  .content{padding:20px}
  .chips{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
  .chip{background:#eef;border:1px solid #99c;border-radius:999px;padding:6px 10px}
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px}
  .card{border:1px solid #ddd;border-radius:8px;overflow:hidden;background:#fff}
  .card img{width:100%;height:150px;object-fit:cover}
  .card-body{padding:10px}
  .btn{display:inline-block;padding:8px 12px;border:1px solid #333;border-radius:6px;text-decoration:none;background:#f7f7f7}
  .btn.primary{background:#007bff;color:#fff;border-color:#007bff}
  input{padding:8px;border:1px solid #bbb;border-radius:6px}
</style>
</head>
<body>
<div class="container">
  <aside class="sidebar"><?php include __DIR__."/../partials/sidebar.php"; ?></aside>

  <main class="main">
    <header class="header">
      <div class="title">Compare · Select Cars</div>
      <div>
        <a class="btn" href="index.php?route=cars/compare/show">View Comparison</a>
        <a class="btn" href="index.php?route=cars/compare/clear" onclick="return confirm('Clear selected cars?')">Clear</a>
      </div>
    </header>

    <div class="content">
      <div class="chips">
        <?php foreach ($selected as $s): ?>
          <span class="chip">
            <?= htmlspecialchars($s['brand'].' '.$s['model']) ?>
            <a href="index.php?route=cars/compare/remove&id=<?= (int)$s['id'] ?>" style="margin-left:6px;text-decoration:none">✕</a>
          </span>
        <?php endforeach; ?>
        <?php if (!$selected): ?>
          <em style="color:#666">No cars selected yet. Pick up to 3.</em>
        <?php endif; ?>
      </div>

      <!-- Quick search -->
      <form method="get" action="index.php" style="margin-bottom:12px;display:flex;gap:8px;align-items:center">
        <input type="hidden" name="route" value="cars/compare">
        <input name="q" placeholder="Search by brand/model/variant…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button class="btn">Search</button>
        <a class="btn" href="index.php?route=cars/compare">Reset</a>
      </form>

      <!-- Catalog to add -->
      <div class="grid">
        <?php while($c = $carsList->fetch_assoc()): ?>
          <div class="card">
            <img src="<?= htmlspecialchars($imgModel->cover($c['id'])) ?>" alt="">
            <div class="card-body">
              <div style="font-weight:600"><?= htmlspecialchars($c['brand'].' '.$c['model']) ?></div>
              <div style="color:#007bff;font-weight:700">$<?= number_format((float)$c['asking_price'],2) ?></div>
              <?php if (!in_array($c['id'], $_SESSION['compare_ids'], true)): ?>
                <form method="post" action="index.php?route=cars/compare/add" style="margin-top:8px">
                  <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
                  <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                  <button class="btn primary" type="submit">Add to Compare</button>
                </form>
              <?php else: ?>
                <div style="margin-top:8px;color:#0a0">Already selected</div>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="footer" style="padding:12px;border-top:1px solid #ccc;text-align:center;color:#777">© CarDealer</div>
  </main>
</div>
</body>
</html>
