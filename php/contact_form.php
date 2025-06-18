<?php
require_once 'db.php'; // Adjust if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            // Message saved successfully
            header('Location: ../contact.html?success=1');
            exit();
        } else {
            // Log DB error for admin (optional)
            error_log("DB error: " . $stmt->error);
            header('Location: ../contact.html?error=db');
            exit();
        }
    } else {
        // Missing fields
        header('Location: ../contact.html?error=fields');
        exit();
    }
} else {
    // Invalid access method
    header('Location: ../contact.html');
    exit();
}
