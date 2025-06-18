<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order info
$sql_order = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    echo "Order not found.";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items
$sql_items = "SELECT * FROM order_items WHERE order_id = ?";
$stmt2 = $conn->prepare($sql_items);
$stmt2->bind_param("i", $order_id);
$stmt2->execute();
$items_result = $stmt2->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Details - Admin</title>
    <link rel="stylesheet" href="admin_style.css" />
</head>
<body>
<header>
    <h1>Crown Coffee Admin Dashboard</h1>
    <nav>
        <a href="dashboard.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <h2>Order Details: #<?php echo htmlspecialchars($order['order_id']); ?></h2>

    <section class="order-info">
        <h3>Customer Information</h3>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>Province:</strong> <?php echo htmlspecialchars($order['province']); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
        <p><strong>Order Status:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
    </section>

    <section class="order-items">
        <h3>Items</h3>
        <?php if ($items_result->num_rows > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Item Price ($)</th>
                        <th>Subtotal ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($item = $items_result->fetch_assoc()): 
                        $subtotal = $item['quantity'] * $item['item_price'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo number_format($item['item_price'], 2); ?></td>
                            <td><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>
    </section>

    <section class="order-totals">
        <h3>Totals</h3>
        <p><strong>Subtotal:</strong> $<?php echo number_format($order['subtotal'], 2); ?></p>
        <p><strong>GST:</strong> $<?php echo number_format($order['gst'], 2); ?></p>
        <p><strong>Past:</strong> $<?php echo number_format($order['past'], 2); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
    </section>

    <p><a href="orders.php">&larr; Back to Orders</a></p>
</main>
</body>
</html>
