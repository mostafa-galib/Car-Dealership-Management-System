<?php
// Figure out current route to highlight active link
$currentRoute = $_GET['route'] ?? 'cars';

function navItem($route, $label, $icon = '•', $currentRoute = ''){
    $active = ($currentRoute === $route) ? 'active' : '';
    $href = "index.php?route=" . $route;
    return "<a class=\"nav-item $active\" href=\"$href\"><span class=\"icon\">$icon</span><span>$label</span></a>";
}
?>
<div class="sidebar-brand">CarDealer</div>

<div class="nav-section">
  <div class="nav-section-title">Browse</div>
  <?= navItem('cars', 'Cars', '🚗', $currentRoute) ?>
  <?php if (!empty($_SESSION['customer_id'])): ?>
    <?= navItem('testdrives/my', 'My Test Drives', '🗓️', $currentRoute) ?>
    <?= navItem('reservations/my', 'My Reservations', '📌', $currentRoute) ?>
  <?php endif; ?>
</div>

