<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET name=?, email=?, phone_number=?, address=?, password=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $hashed_password, $user_id);
    } else {
        $query = "UPDATE users SET name=?, email=?, phone_number=?, address=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = '../profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.'); window.location.href = '../profile.php';</script>";
    }
}
?>
