<?php
session_start();
require 'php/db.php';                // ✅ DB needed to check stock
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Your Cart – Crown Coffee</title>
  <link rel="stylesheet" href="CSS/user_pannel.css">
  <style>
    .btn{background:#6b4c3b;color:#fff;padding:8px 18px;border:none;border-radius:5px;text-decoration:none;cursor:pointer}
    .btn:hover{background:#53341f}
    .stock-msg{color:#d9534f;font-weight:600;margin-top:4px}
    table{width:100%;border-collapse:collapse;margin-bottom:2rem}
    th,td{border:1px solid #ddd;padding:8px;text-align:center}
    th{background:#6b4c3b;color:#fff}
  </style>
</head>
<body>

<header class="header">
  <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Crown Coffee Logo"></a></div>
  <nav class="nav">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="blog.php">Blog</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main class="container">

  <h2 style="text-align:center;margin:2rem 0;">Items in Your Cart</h2>

  <?php
  /* ─────────  flash message if stock exceeded  ───────── */
  if (!empty($_SESSION['stock_error'])) {
      echo '<p class="stock-msg" style="text-align:center;">'.$_SESSION['stock_error'].'</p>';
      unset($_SESSION['stock_error']);
  }

  $total = 0;

  if (!empty($_SESSION['cart'])):

      echo '<table><thead><tr>
              <th>Product</th><th>Price ($)</th><th>Qty</th><th>Subtotal ($)</th><th></th>
            </tr></thead><tbody>';

      foreach ($_SESSION['cart'] as $id => $item):
          /* fetch current stock so we can disable “+” if limit reached */
          $stmt = $conn->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
          $stmt->bind_param("i",$id);
          $stmt->execute();
          $stock = $stmt->get_result()->fetch_assoc()['stock_quantity'] ?? 0;

          $subtotal = $item['price'] * $item['quantity'];
          $total   += $subtotal;
  ?>
          <tr>
            <td style="text-align:left; display:flex; align-items:center; gap:10px;">
              <?php if (!empty($item['image'])): ?>
                <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:100px; height:auto; border-radius:6px; object-fit:cover;">
              <?php endif; ?>
              <div>
                <?= htmlspecialchars($item['name']) ?>
                <?php if ($stock <= 5 && $stock > 0): ?>
                   <div class="stock-msg">Only <?= $stock ?> left!</div>
                <?php endif; ?>
                <?php if ($stock == 0): ?>
                   <div class="stock-msg">💥 Out of Stock (remove item)</div>
                <?php endif; ?>
              </div>
            </td>

            <td><?= number_format($item['price'],2) ?></td>

            <td>
              <form style="display:inline" method="POST" action="php/update_quantity.php">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" name="action" value="decrease" <?= $item['quantity']==1?'disabled':'' ?>>−</button>
              </form>

              <span style="margin:0 10px;"><?= $item['quantity'] ?></span>

              <form style="display:inline" method="POST" action="php/update_quantity.php">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" name="action" value="increase" <?= $item['quantity'] >= $stock ? 'disabled' : '' ?>>+</button>
              </form>
            </td>

            <td><?= number_format($subtotal,2) ?></td>

            <td>
              <form method="POST" action="php/remove_from_cart.php">
                  <input type="hidden" name="product_id" value="<?= $id ?>">
                  <button type="submit" class="btn">Remove</button>
              </form>
            </td>
          </tr>
  <?php
      endforeach;
      echo '</tbody></table>';
      echo '<h3 style="text-align:center;">Total: $'.number_format($total,2).'</h3>';
      echo '<div style="text-align:center; margin:2rem 0;"><a href="checkout.php" class="btn">Proceed to Checkout</a></div>';

  else:
      echo '<p style="text-align:center;">Your cart is empty.</p>';
  endif;
  ?>

</main>
</body>
</html>
