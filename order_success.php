<?php
require 'php/db.php';
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    header("Location: index.html");
    exit();
}

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "Order not found.";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Order Confirmation - Crown Coffee</title>
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
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="blog.html">Blog</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>
</header>

<section class="checkout-section" style="text-align:center;">
  <h2>Thank You for Your Order!</h2>
  <p>Your order number is: <strong>#<?= htmlspecialchars($order['order_id']) ?></strong></p>
  <p>We will email the confirmation to: <strong><?= htmlspecialchars($order['email']) ?></strong></p>
  <a href="index.php" class="btn">Continue Shopping</a>
</section>
</body>
</html>
