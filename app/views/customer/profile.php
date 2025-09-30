<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Profile · CarDealer</title>
  <link rel="stylesheet" href="assets/css/app.css">
  <style>
    html,body{height:100%}
    body{
      margin:0;font-family:sans-serif;background:#111827;color:#e5e7eb;
      display:flex;align-items:center;justify-content:center;
    }
    .card{
      width:100%;max-width:520px;background:#1f2937;border:1px solid #374151;border-radius:12px;
      padding:26px;box-shadow:0 6px 20px rgba(0,0,0,.6);
    }
    h2{margin:0 0 14px;font-size:22px;font-weight:700;color:#f9fafb}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .field{display:flex;flex-direction:column;margin-bottom:12px}
    .field label{font-size:13px;font-weight:600;margin-bottom:6px;color:#d1d5db}
    .input{
      height:42px;padding:0 12px;border:1px solid #4b5563;border-radius:8px;background:#111827;color:#f9fafb;
    }
    .input::placeholder{color:#9ca3af}
    .btn{width:100%;padding:12px;border:none;border-radius:8px;background:#2563eb;color:#fff;font-weight:700;cursor:pointer}
    .btn:hover{background:#1d4ed8}
    .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
    .muted{color:#9ca3af;font-size:13px}
    .ok{background:#064e3b;border:1px solid #065f46;color:#d1fae5;padding:8px 10px;border-radius:8px;margin-bottom:10px}
    .err{background:#7f1d1d;border:1px solid #b91c1c;color:#fee2e2;padding:8px 10px;border-radius:8px;margin-bottom:10px}
    a.link{color:#93c5fd;text-decoration:none}
  </style>
</head>
<body>
  <div class="card">
    <div class="top">
      <h2>Edit Profile</h2>
      <a class="link" href="index.php?route=cars">← Back</a>
    </div>

    <?php if (!empty($_GET['updated'])): ?>
      <div class="ok">Profile updated successfully.</div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="err">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?route=customer/profile_update">
      <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">

      <div class="field">
        <label for="name">Name</label>
        <input class="input" id="name" name="name" value="<?= htmlspecialchars($cust['name'] ?? '') ?>" required>
      </div>

      <div class="row">
        <div class="field">
          <label for="email">Email</label>
          <input class="input" id="email" type="email" name="email" value="<?= htmlspecialchars($cust['email'] ?? '') ?>" required>
        </div>
        <div class="field">
          <label for="phone">Phone</label>
          <input class="input" id="phone" name="phone" value="<?= htmlspecialchars($cust['phone'] ?? '') ?>">
        </div>
      </div>

      <div class="muted" style="margin:6px 0 8px">Change password (optional)</div>
      <div class="row">
        <div class="field">
          <label for="old_password">Current Password</label>
          <input class="input" id="old_password" type="password" name="old_password" placeholder="••••••••">
        </div>
        <div class="field">
          <label for="new_password">New Password</label>
          <input class="input" id="new_password" type="password" name="new_password" placeholder="••••••••">
        </div>
      </div>
      <div class="field">
        <label for="confirm_password">Confirm New Password</label>
        <input class="input" id="confirm_password" type="password" name="confirm_password" placeholder="••••••••">
      </div>

      <button class="btn" type="submit">Save Changes</button>
    </form>
  </div>
</body>
</html>
