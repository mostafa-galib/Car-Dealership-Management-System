<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin · Cars</title>
  <style>
    body{font-family:sans-serif}
    table{border-collapse:collapse;width:100%}
    th,td{border:1px solid #ddd;padding:8px}
    th{background:#f3f3f3;text-align:left}
    .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
    .btn{display:inline-block;padding:8px 12px;border:1px solid #333;border-radius:6px;text-decoration:none;background:#f7f7f7}
    .btn.primary{background:#007bff;color:#fff;border-color:#007bff}
  </style>
</head>
<body>
  <div class="topbar">
    <h2>Cars</h2>
    <div>
      <a class="btn" href="index.php?route=admin/dashboard">Dashboard</a>
      <a class="btn primary" href="index.php?route=admin/cars/create">+ Add Car</a>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Brand</th><th>Model</th><th>Variant</th><th>Year</th><th>Status</th><th>Price</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($c = $cars->fetch_assoc()): ?>
      <tr>
        <td><?= (int)$c['id'] ?></td>
        <td><?= htmlspecialchars($c['brand']) ?></td>
        <td><?= htmlspecialchars($c['model']) ?></td>
        <td><?= htmlspecialchars($c['variant']) ?></td>
        <td><?= htmlspecialchars($c['year']) ?></td>
        <td><?= htmlspecialchars($c['status']) ?></td>
        <td>$<?= number_format((float)$c['asking_price'],2) ?></td>
        <td>
          <a class="btn" href="index.php?route=admin/cars/edit&id=<?= (int)$c['id'] ?>">Edit</a>
          <a class="btn" href="index.php?route=admin/cars/delete&id=<?= (int)$c['id'] ?>" onclick="return confirm('Delete this car?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
