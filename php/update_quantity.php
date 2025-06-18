<?php
session_start();

if (isset($_POST['product_id'], $_POST['action'])) {
    $id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$id])) {
        if ($_POST['action'] == 'increase') {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } elseif ($_POST['action'] == 'decrease') {
            $_SESSION['cart'][$id]['quantity'] -= 1;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]); // remove if 0
            }
        }
    }
}
header("Location: ../cart.php");
exit();
