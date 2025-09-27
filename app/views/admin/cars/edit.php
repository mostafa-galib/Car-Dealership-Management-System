<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin · Edit Car</title>
  <style>
    body{font-family:sans-serif}
    form .row{display:grid;grid-template-columns:repeat(2,minmax(240px,1fr));gap:12px}
    label{display:block;font-weight:600;margin-top:10px}
    input,select{width:100%;padding:8px;border:1px solid #bbb;border-radius:6px}
    .actions{margin-top:16px}
    .btn{display:inline-block;padding:8px 12px;border:1px solid #333;border-radius:6px;text-decoration:none;background:#f7f7f7}
    .btn.primary{background:#007bff;color:#fff;border-color:#007bff}
    .section{margin-top:24px;padding-top:12px;border-top:1px solid #ddd}
    .thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-top:12px}
    .card{border:1px solid #ddd;border-radius:8px;padding:8px}
    .card img{width:100%;height:120px;object-fit:cover;border-radius:6px}
    .small{font-size:12px;color:#555}
    .form-inline{display:flex;gap:8px;align-items:center;margin-top:6px}
  </style>
</head>
<body>
  <h2>Edit Car #<?= (int)$car['id'] ?></h2>
  <form method="post" action="index.php?route=admin/cars/update">
    <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="id" value="<?= (int)$car['id'] ?>">

    <div class="row">
      <div><label>Brand</label><input name="brand" value="<?= htmlspecialchars($car['brand']) ?>" required></div>
      <div><label>Model</label><input name="model" value="<?= htmlspecialchars($car['model']) ?>" required></div>
      <div><label>Variant</label><input name="variant" value="<?= htmlspecialchars($car['variant']) ?>"></div>
      <div><label>Year</label><input type="number" name="year" min="1900" max="2100" value="<?= htmlspecialchars($car['year']) ?>"></div>
      <div><label>Color</label><input name="color" value="<?= htmlspecialchars($car['color']) ?>"></div>
      <div><label>Fuel Type</label><input name="fuel_type" value="<?= htmlspecialchars($car['fuel_type']) ?>"></div>
      <div><label>Transmission</label><input name="transmission" value="<?= htmlspecialchars($car['transmission']) ?>"></div>
      <div><label>Engine CC</label><input type="number" name="engine_cc" value="<?= htmlspecialchars($car['engine_cc']) ?>"></div>
      <div><label>Power (HP)</label><input type="number" name="power_hp" value="<?= htmlspecialchars($car['power_hp']) ?>"></div>
      <div><label>Mileage (km/l)</label><input type="number" step="0.1" name="mileage_kmpl" value="<?= htmlspecialchars($car['mileage_kmpl']) ?>"></div>
      <div><label>Seats</label><input type="number" name="seats" value="<?= htmlspecialchars($car['seats']) ?>"></div>
      <div><label>Airbags</label><input type="number" name="airbags" value="<?= htmlspecialchars($car['airbags']) ?>"></div>
      <div><label>VIN</label><input name="vin" value="<?= htmlspecialchars($car['vin']) ?>"></div>
      <div>
        <label>Status</label>
        <select name="status">
          <option value="in_stock" <?= ($car['status']==='in_stock'?'selected':'') ?>>In Stock</option>
          <option value="reserved" <?= ($car['status']==='reserved'?'selected':'') ?>>Reserved</option>
          <option value="sold" <?= ($car['status']==='sold'?'selected':'') ?>>Sold</option>
        </select>
      </div>
      <div><label>Asking Price (USD)</label><input type="number" step="0.01" name="asking_price" value="<?= htmlspecialchars($car['asking_price']) ?>"></div>
    </div>

    <div class="actions">
      <button class="btn primary" type="submit">Update</button>
      <a class="btn" href="index.php?route=admin/cars">Back</a>
    </div>
  </form>

  <div class="section">
    <h3>Images</h3>

    <!-- Upload -->
    <form class="form-inline" method="post" enctype="multipart/form-data" action="index.php?route=admin/cars/uploadImage">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <input type="hidden" name="unit_id" value="<?= (int)$car['id'] ?>">
      <input type="file" name="image" accept="image/*" required>
      <button class="btn" type="submit">Upload</button>
      <span class="small">Allowed: JPG, PNG, WEBP, GIF</span>
    </form>

    <!-- List -->
    <div class="thumbs">
      <?php while($im = $images->fetch_assoc()): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($im['image_path']) ?>" alt="">
          <div class="small"><?= $im['is_cover'] ? '⭐ Cover' : 'Gallery' ?> · Sort: <?= (int)$im['sort_order'] ?></div>

          <div class="form-inline">
            <?php if (!$im['is_cover']): ?>
              <a class="btn" href="index.php?route=admin/cars/setCover&id=<?= (int)$im['id'] ?>">Set Cover</a>
            <?php else: ?>
              <span class="small">Current cover</span>
            <?php endif; ?>

            <a class="btn" href="index.php?route=admin/cars/deleteImage&id=<?= (int)$im['id'] ?>" onclick="return confirm('Delete this image?')">Delete</a>
          </div>

          <form class="form-inline" method="post" action="index.php?route=admin/cars/updateSort">
            <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
            <input type="hidden" name="image_id" value="<?= (int)$im['id'] ?>">
            <input type="number" name="sort_order" value="<?= (int)$im['sort_order'] ?>" style="width:90px">
            <button class="btn" type="submit">Update Sort</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
