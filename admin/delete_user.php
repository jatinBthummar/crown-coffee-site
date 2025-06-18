<?php
require_once 'admin_auth.php';  // make sure admin is logged in
include '../php/db.php';

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // sanitize input

    // Optional: Prevent deleting admin user itself or current logged in user
    if ($user_id === $_SESSION['admin_user_id']) {
        // prevent deleting current admin
        header("Location: manage_users.php?error=cannot_delete_self");
        exit();
    }

    // Delete query
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        // Success, redirect back with success message
        header("Location: manage_users.php?success=deleted");
        exit();
    } else {
        // Failure
        header("Location: manage_users.php?error=delete_failed");
        exit();
    }
} else {
    // No id passed
    header("Location: manage_users.php?error=no_id");
    exit();
}
