<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sales · Test Drives</title>
  <style>
    body{font-family:sans-serif;margin:20px}
    header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    table{border-collapse:collapse;width:100%}
    th,td{border:1px solid #ccc;padding:8px;text-align:left}
    th{background:#f4f4f4}
    form{display:inline}
    .btn{padding:6px 10px;border:1px solid #333;border-radius:4px;background:#eee;text-decoration:none;cursor:pointer}
    .btn { padding:6px 10px; border:1px solid #333; border-radius:6px; background:#f7f7f7; text-decoration:none }
  </style>
</head>
<body>
  <header>
    <h2>Manage Test Drives</h2>
    <div>
      <a class="btn primary" href="index.php?route=sales/dashboard">← Dashboard</a>
    </div>
  </header>

  <table>
    <tr>
      <th>ID</th><th>Customer</th><th>Car</th><th>Preferred</th>
      <th>Status</th><th>Notes</th><th>Action</th>
    </tr>
    <?php while($row=$list->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['customer_name']) ?></td>
      <td><?= htmlspecialchars($row['brand'].' '.$row['model']) ?></td>
      <td><?= htmlspecialchars($row['preferred_datetime']) ?></td>
      <td><?= htmlspecialchars($row['status']) ?></td>
      <td><?= htmlspecialchars($row['notes']) ?></td>
      <td>
        <form method="post" action="index.php?route=sales/testdrives/updateStatus">
          <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <select name="status">
            <option value="approved">Approve</option>
            <option value="completed">Complete</option>
            <option value="cancelled">Cancel</option>
          </select>
          <input type="text" name="notes" placeholder="Notes">
          <button class="btn">Update</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
