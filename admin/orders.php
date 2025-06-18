<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connect.php';

// Fetch all orders, sorted by newest first
$sql = "SELECT order_id, fullname, order_date, order_status, total FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Orders - Admin</title>
    <link rel="stylesheet" href="admin_style.css" />
</head>
<body>
    <header>
        <h1>Crown Coffee Admin Dashboard</h1>
        <nav>
            <a href="dashboard.php">Products</a>
            <a href="orders.php" class="active">Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>All Orders</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Total ($)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                            <td><?php echo number_format($order['total'], 2); ?></td>
                            <td>
                                <a href="order_details.php?id=<?php echo $order['order_id']; ?>">View Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
