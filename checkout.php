<?php
session_start();
require 'php/db.php'; // Your DB connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // User NOT logged in, show message and login button, then stop further rendering
  echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Login Required</title>';
  echo '<link rel="stylesheet" href="CSS/user_pannel.css" />';
  echo '<style>
          body { font-family: Arial, sans-serif; text-align: center; padding: 3rem; background: #f9f9f9; }
          .btn { background-color: #6b4c3b; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-size: 1.1rem; }
        </style>';
  echo '</head><body>';
  echo '<h2>You must be logged in to place an order.</h2>';
  echo '<p>Please log in first to continue to checkout.</p>';
  echo '<a href="login.php" class="btn">Go to Login</a>';
  echo '</body></html>';
  exit(); // Stop further execution
}

// Canadian taxes: GST = 5%, PST varies by province (let's say 7% for example)
define('GST_RATE', 0.05);
define('PST_RATE', 0.07);

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
$gst = $total * GST_RATE;
$pst = $total * PST_RATE;
$grand_total = $total + $gst + $pst;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Checkout - Crown Coffee</title>
  <link rel="stylesheet" href="CSS/user_pannel.css" />
</head>
<body>
<header class="header">
  <div class="logo">
    <a href="index.html">
      <img src="images/logo.png" alt="Crown Coffee Logo" />
    </a>
  </div>
  <nav class="nav">
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="shop.html">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="blog.php">Blog</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="logout.php">Logout</a></li>

    </ul>
  </nav>
</header>

<section class="checkout-section">
  <h2>Checkout</h2>

  <form action="php/process_order.php" method="POST" class="checkout-form">
    <fieldset>
      <legend>Billing Information</legend>
      <label for="fullname">Full Name</label>
      <input type="text" name="fullname" id="fullname" required />

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required />

      <label for="address">Shipping Address</label>
      <textarea name="address" id="address" rows="3" required></textarea>

      <label for="province">Province</label>
      <select name="province" id="province" required>
        <option value="">--Select Province--</option>
        <option value="ON">Ontario</option>
        <option value="QC">Quebec</option>
        <option value="BC">British Columbia</option>
        <option value="AB">Alberta</option>
        <option value="MB">Manitoba</option>
        <option value="SK">Saskatchewan</option>
        <option value="NS">Nova Scotia</option>
        <option value="NB">New Brunswick</option>
        <option value="NL">Newfoundland and Labrador</option>
        <option value="PE">Prince Edward Island</option>
        <option value="NT">Northwest Territories</option>
        <option value="YT">Yukon</option>
        <option value="NU">Nunavut</option>
      </select>

      <!-- You can add payment method options here -->
    </fieldset>

    <fieldset>
      <legend>Order Summary</legend>
      <div class="order-items">
        <?php foreach ($_SESSION['cart'] as $item): ?>
          <div class="order-item">
            <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
            <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="order-totals">
        <div><strong>Subtotal:</strong> $<?= number_format($total, 2) ?></div>
        <div><strong>GST (5%):</strong> $<?= number_format($gst, 2) ?></div>
        <div><strong>PST (7%):</strong> $<?= number_format($pst, 2) ?></div>
        <div><strong>Total:</strong> $<?= number_format($grand_total, 2) ?></div>
      </div>
    </fieldset>

    <button type="submit" class="btn">Place Order</button>
  </form>
</section>

</body>
</html>
