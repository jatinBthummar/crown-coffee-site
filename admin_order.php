<?php
session_start();
require 'php/db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$query = "SELECT orders.order_id, orders.user_id, users.name, orders.total_price, orders.order_status, orders.order_date 
          FROM orders 
          JOIN users ON orders.user_id = users.user_id 
          ORDER BY orders.order_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Orders | Crown Coffee</title>
  <link rel="stylesheet" href="css/user_pannel.css" />
</head>
<body>
  <div class="admin-container">
    <h2>All Customer Orders</h2>

    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>User</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Date</th>
          <th>Update Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($order = $result->fetch_assoc()) : ?>
        <tr>
          <td><?= $order['order_id'] ?></td>
          <td><?= htmlspecialchars($order['name']) ?> (ID: <?= $order['user_id'] ?>)</td>
          <td>$<?= number_format($order['total_price'], 2) ?></td>
          <td><?= $order['order_status'] ?></td>
          <td><?= $order['order_date'] ?></td>
          <td>
            <form action="php/update_order_status.php" method="POST">
              <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
              <select name="status">
                <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Processing" <?= $order['order_status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                <option value="Shipped" <?= $order['order_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
              </select>
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
