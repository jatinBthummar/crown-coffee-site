<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit();
}

require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $province = trim($_POST['province']);
    $password = trim($_POST['password']); // If you want password here
    
    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Name, Email, and Password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email exists already
        $stmtCheck = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            $error = "Email already exists. Please use a different email.";
        } else {
            // Hash password before storing
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmtInsert = $conn->prepare("INSERT INTO users (name, email, phone, province, password) VALUES (?, ?, ?, ?, ?)");
            $stmtInsert->bind_param("sssss", $name, $email, $phone, $province, $passwordHash);
            if ($stmtInsert->execute()) {
                $success = "New user added successfully.";
                // Clear form data
                $name = $email = $phone = $province = $password = '';
            } else {
                $error = "Failed to add new user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add New User - Crown Coffee Admin</title>
  <link rel="stylesheet" href="../CSS/admin.css" />
  <style>
    .admin-container {
      max-width: 500px;
      margin: 3rem auto;
      background: #fff9f4;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 3px 12px rgba(92,61,46,0.35);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
      text-align: center;
      color: #5c3d2e;
      margin-bottom: 2rem;
    }

    label {
      display: block;
      margin-bottom: 0.4rem;
      color: #5c3d2e;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 1.2rem;
      border: 1.8px solid #d9c9b9;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #5c3d2e;
      outline: none;
    }

    .btn-submit {
      width: 100%;
      padding: 10px 0;
      background-color: #5c3d2e;
      border: none;
      color: white;
      font-weight: 700;
      border-radius: 10px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
      background-color: #4a2f23;
    }

    .btn-back {
      display: inline-block;
      margin-bottom: 1.5rem;
      color: #5c3d2e;
      font-weight: 600;
      text-decoration: none;
      font-size: 0.95rem;
    }

    .error-msg {
      background-color: #f8d7da;
      color: #842029;
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1.5px solid #f5c2c7;
      font-weight: 600;
    }

    .success-msg {
      background-color: #d1e7dd;
      color: #0f5132;
      padding: 12px 15px;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1.5px solid #badbcc;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <a href="manage_users.php" class="btn-back">← Back to Manage Users</a>
    <h1>Add New User</h1>

    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success-msg"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <label for="name">Name *</label>
      <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required />

      <label for="email">Email *</label>
      <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required />

      <label for="phone">Phone</label>
      <input type="text" id="phone" name="phone" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>" />

      <label for="province">Province</label>
      <input type="text" id="province" name="province" value="<?= isset($province) ? htmlspecialchars($province) : '' ?>" />

      <label for="password">Password *</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" class="btn-submit">Add User</button>
    </form>
  </div>
</body>
</html>
