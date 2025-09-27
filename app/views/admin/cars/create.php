<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin · Add Car</title>
  <style>
    body{font-family:sans-serif}
    form .row{display:grid;grid-template-columns:repeat(2,minmax(240px,1fr));gap:12px}
    label{display:block;font-weight:600;margin-top:10px}
    input,select{width:100%;padding:8px;border:1px solid #bbb;border-radius:6px}
    .actions{margin-top:16px}
    .btn{display:inline-block;padding:8px 12px;border:1px solid #333;border-radius:6px;text-decoration:none;background:#f7f7f7}
    .btn.primary{background:#007bff;color:#fff;border-color:#007bff}
  </style>
</head>
<body>
  <h2>Add Car</h2>
  <form method="post" action="index.php?route=admin/cars/store">
    <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">

    <div class="row">
      <div>
        <label>Brand</label>
        <input name="brand" required>
      </div>
      <div>
        <label>Model</label>
        <input name="model" required>
      </div>

      <div>
        <label>Variant</label>
        <input name="variant">
      </div>
      <div>
        <label>Year</label>
        <input type="number" name="year" min="1900" max="2100">
      </div>

      <div>
        <label>Color</label>
        <input name="color">
      </div>
      <div>
        <label>Fuel Type</label>
        <input name="fuel_type" placeholder="Petrol/Diesel/Hybrid/Electric">
      </div>

      <div>
        <label>Transmission</label>
        <input name="transmission" placeholder="Manual/Automatic/CVT">
      </div>
      <div>
        <label>Engine CC</label>
        <input type="number" name="engine_cc" min="0">
      </div>

      <div>
        <label>Power (HP)</label>
        <input type="number" name="power_hp" min="0">
      </div>
      <div>
        <label>Mileage (km/l)</label>
        <input type="number" step="0.1" name="mileage_kmpl" min="0">
      </div>

      <div>
        <label>Seats</label>
        <input type="number" name="seats" min="1">
      </div>
      <div>
        <label>Airbags</label>
        <input type="number" name="airbags" min="0">
      </div>

      <div>
        <label>VIN</label>
        <input name="vin">
      </div>
      <div>
        <label>Status</label>
        <select name="status">
          <option value="in_stock">In Stock</option>
          <option value="reserved">Reserved</option>
          <option value="sold">Sold</option>
        </select>
      </div>

      <div>
        <label>Asking Price (USD)</label>
        <input type="number" step="0.01" name="asking_price" min="0">
      </div>
    </div>

    <div class="actions">
      <button class="btn primary" type="submit">Save</button>
      <a class="btn" href="index.php?route=admin/cars">Cancel</a>
    </div>
  </form>
</body>
</html>
