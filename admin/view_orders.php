<?php
require '../php/db.php';
require 'admin_auth.php';
include 'admin_header.php'; // Include common header

// Update Order Status
if (isset($_GET['mark_complete'])) {
    $oid = intval($_GET['mark_complete']);
    $conn->query("UPDATE orders SET order_status = 'Completed' WHERE order_id = $oid");
}

// Delete Order
if (isset($_GET['delete_order'])) {
    $oid = intval($_GET['delete_order']);
    $conn->query("DELETE FROM order_items WHERE order_id = $oid");
    $conn->query("DELETE FROM orders WHERE order_id = $oid");
}

// Filter pending orders if requested
$statusFilter = '';
$pageTitle = 'All Orders';

if (isset($_GET['status']) && $_GET['status'] === 'pending') {
    $statusFilter = "WHERE order_status = 'pending'";
    $pageTitle = 'Pending Orders';
}

$sql = "SELECT * FROM orders $statusFilter ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!-- Main Content -->
<div class="container">
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h2><?= $pageTitle ?></h2>
    <!-- Back Button -->
    <a href="dashboard.php" style="padding: 0.5rem 1rem; background-color: #6b4226; color: white; border-radius: 5px; text-decoration: none;">← Back to Dashboard</a>
  </div>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($order = $result->fetch_assoc()): ?>
      <div class="order-box" style="border: 1px solid #ccc; padding: 1rem; margin: 1rem 0; border-radius: 8px;">
        <p><strong>Order ID:</strong> <?= $order['order_id'] ?></p>
        <p><strong>Name:</strong> <?= $order['fullname'] ?></p>
        <p><strong>Email:</strong> <?= $order['email'] ?></p>
        <p><strong>Address:</strong> <?= $order['address'] ?></p>
        <p><strong>Province:</strong> <?= $order['province'] ?></p>
        <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
        <p><strong>Status:</strong> <?= $order['order_status'] ?></p>

        <div style="margin-top:10px;">
          <?php if ($order['order_status'] !== 'Completed'): ?>
            <a href="view_orders.php?mark_complete=<?= $order['order_id'] ?>" onclick="return confirm('Mark as completed?')" style="margin-right: 10px; background: #28a745; color: #fff; padding: 5px 10px; border-radius: 5px; text-decoration: none;">✅ Mark as Completed</a>
          <?php endif; ?>
          <a href="view_orders.php?delete_order=<?= $order['order_id'] ?>" onclick="return confirm('Are you sure to delete this order?')" style="background: #dc3545; color: #fff; padding: 5px 10px; border-radius: 5px; text-decoration: none;">🗑️ Delete Order</a>
        </div>

        <h4 style="margin-top:1rem;">Items:</h4>
        <ul>
        <?php
          $oid = $order['order_id'];
          $items = $conn->query("SELECT * FROM order_items WHERE order_id = $oid");
          while ($item = $items->fetch_assoc()):
        ?>
          <li><?= $item['product_name'] ?> - <?= $item['quantity'] ?> × $<?= number_format($item['item_price'], 2) ?></li>
        <?php endwhile; ?>
        </ul>

        <p><strong>Subtotal:</strong> $<?= number_format($order['subtotal'], 2) ?></p>
        <p><strong>GST:</strong> $<?= number_format($order['gst'], 2) ?></p>
        <p><strong>PST:</strong> $<?= number_format($order['pst'], 2) ?></p>
        <p><strong>Total:</strong> $<?= number_format($order['total'], 2) ?></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="margin-top:2rem;">No <?= strtolower($pageTitle) ?> found.</p>
  <?php endif; ?>
</div>

</main> <!-- Closes main-content opened in admin_header.php -->
</body>
</html>
