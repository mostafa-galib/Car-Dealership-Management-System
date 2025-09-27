<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin · System Settings</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{ --border:#e5e7eb; --muted:#64748b; --primary:#16a34a; }
    body{font-family:sans-serif;margin:0;background:#f8fafc;color:#0f172a}
    .wrap{max-width:880px;margin:40px auto;padding:0 16px}
    h1{margin:0 0 14px}
    .card{background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
    .field{display:flex;flex-direction:column;gap:6px}
    label{font-weight:600}
    input{height:40px;padding:0 12px;border:1px solid var(--border);border-radius:8px}
    .help{font-size:12px;color:var(--muted)}
    .actions{margin-top:16px;display:flex;gap:10px}
    .btn{padding:10px 14px;border-radius:10px;border:1px solid #111;background:#f3f4f6;text-decoration:none;cursor:pointer}
    .btn.primary{background:#ccc;border-color:var(--primary);color:#}
    table{width:100%;border-collapse:collapse;margin-top:22px}
    th,td{border-bottom:1px solid var(--border);padding:10px;text-align:left}
    th{background:#f8fafc}
    .back{margin-top:14px;display:inline-block}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>System Settings</h1>
    <form method="post" action="index.php?route=admin/settings/save" class="card">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
      <div class="row">
        <div class="field">
          <label>Default Tax Rate (%)</label>
          <input type="number" step="0.01" min="0" name="default_tax_rate"
                 value="<?php
                   // try to fetch existing value from $rows result set
                   $tax=''; $hold=48;
                   if ($rows) { $rows->data_seek(0); while($r=$rows->fetch_assoc()){
                     if ($r['key']==='default_tax_rate') $tax=$r['value'];
                     if ($r['key']==='reservation_hold_hours' && $r['reservation_hold_hours']!=='') $hold = (int)$r['reservation_hold_hours'];
                   } }
                   echo htmlspecialchars($tax);
                 ?>">
          <div class="help">Used for future features (quotes/invoices).</div>
        </div>
        <div class="field">
          <label>Reservation Hold (hours)</label>
          <input type="number" min="1" name="reservation_hold_hours" value="<?= (int)($hold ?? 48) ?>">
          <div class="help">How long a reservation stays pending before auto-expire.</div>
        </div>
      </div>
      <div class="actions">
        <button class="btn primary" type="submit">Save Settings</button>
        <a class="btn" href="index.php?route=admin/dashboard">Back</a>
      </div>
    </form>

    <table>
      <thead><tr><th>Key</th><th>Value</th><th>Hold Hours (compat)</th></tr></thead>
      <tbody>
        <?php if ($rows){ $rows->data_seek(0); while($r=$rows->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['key']) ?></td>
            <td><?= htmlspecialchars($r['value']) ?></td>
            <td><?= htmlspecialchars($r['reservation_hold_hours']) ?></td>
          </tr>
        <?php endwhile; } ?>
      </tbody>
    </table>

    <a class="back" href="index.php?route=admin/dashboard">← Back to Dashboard</a>
  </div>
</body>
</html>
