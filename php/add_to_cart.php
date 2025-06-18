<?php
session_start();
require_once 'db.php'; // Your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);

    // Fetch product info from DB (including image_url)
    $stmt = $conn->prepare("SELECT name, price, image_url, stock_quantity FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($product = $result->fetch_assoc()) {
        // Check stock availability
        if ($product['stock_quantity'] <= 0) {
            $_SESSION['error'] = "Sorry, this product is out of stock.";
            header("Location: ../shop.php");
            exit;
        }

        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add or update product quantity in cart
        if (isset($_SESSION['cart'][$product_id])) {
            if ($_SESSION['cart'][$product_id]['quantity'] < $product['stock_quantity']) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['error'] = "You cannot add more than available stock.";
                header("Location: ../shop.php");
                exit;
            }
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => floatval($product['price']),
                'quantity' => 1,
                'image' => $product['image_url']  // Store the image filename here!
            ];
        }

        header("Location: ../cart.php");
        exit;

    } else {
        // Product not found
        $_SESSION['error'] = "Product not found.";
        header("Location: ../shop.php");
        exit;
    }
}
?>
