<?php
session_start();
require_once '../php/db.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === 'admin' && $pass === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Crown Coffee</title>
  <link rel="stylesheet" href="admin_style.css"> <!-- Optional admin-specific tweaks -->
</head>
<body>
  <header class="main-header">
    <div class="logo">
      <h1>Crown <span>COFFEE</span><br><small>Admin Panel</small></h1>
    </div>
  </header>

  <section class="login-section">
    <div class="form-container">
      <h2>Admin Login</h2>
      <?php if (isset($error)) echo "<p class='error-msg'>$error</p>"; ?>
      <form method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </section>

  <footer class="main-footer">
    <p>&copy; 2025 Crown Coffee. Admin Panel</p>
  </footer>
</body>
</html>
