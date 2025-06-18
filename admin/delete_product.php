<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connect.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$product_id = $_GET['id'];

// Delete product
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    header("Location: dashboard.php?message=Product deleted successfully");
} else {
    header("Location: dashboard.php?message=Error deleting product");
}
?>
