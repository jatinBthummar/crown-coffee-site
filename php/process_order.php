<?php
session_start();
require 'db.php';          // DB connection

/* ---- guard clauses ---- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../checkout.php'); exit();
}
if (
    empty($_POST['fullname']) || empty($_POST['email']) ||
    empty($_POST['address'])  || empty($_POST['province']) ||
    empty($_SESSION['cart'])
) {
    header('Location: ../checkout.php'); exit();
}

/* ---- capture & sanitize ---- */
$user_id  = $_SESSION['user_id'];              // assumes you store this
$fullname = trim($_POST['fullname']);
$email    = trim($_POST['email']);
$address  = trim($_POST['address']);
$province = trim($_POST['province']);
$order_status = 'pending';                     // <‑‑ key line!

/* ---- totals ---- */
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];   // ← cart key is price
}
$gst   = $subtotal * 0.05;
$pst   = $subtotal * 0.07;
$total = $subtotal + $gst + $pst;

/* ---- insert into orders ---- */
$ins  = $conn->prepare(
    "INSERT INTO orders 
        (user_id, fullname, email, address, province,
         subtotal, gst, pst, total, order_status, order_date)
     VALUES (?,?,?,?,?,?,?,?,?, ?, NOW())"
);
if (!$ins) { die('Prepare failed: '.$conn->error); }

$ins->bind_param(
    "isssssddds",
    $user_id, $fullname, $email, $address, $province,
    $subtotal, $gst, $pst, $total, $order_status
);
$ins->execute() or die($ins->error);
$order_id = $ins->insert_id;
$ins->close();

/* ---- order_items & stock update ---- */
$itemIns = $conn->prepare(
    "INSERT INTO order_items
        (order_id, product_id, product_name, quantity, item_price)
     VALUES (?,?,?,?,?)"
);
$stockUp = $conn->prepare(
    "UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?"
);

foreach ($_SESSION['cart'] as $pid => $item) {
    $itemIns->bind_param(
        "iisid",
        $order_id,
        $pid,
        $item['name'],
        $item['quantity'],
        $item['price']
    );
    $itemIns->execute();

    $stockUp->bind_param("ii", $item['quantity'], $pid);
    $stockUp->execute();
}
$itemIns->close();
$stockUp->close();

/* ---- clear cart & redirect ---- */
unset($_SESSION['cart']);
header("Location: ../order_success.php?order_id=$order_id");
exit();
?>
