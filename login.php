<?php
require('php/db.php');
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($uid, $hashed, $role);

    if ($stmt->fetch() && password_verify($pass, $hashed)) {
        $_SESSION['user_id'] = $uid;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: admin_orders.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Crown Coffee</title>

<style>
  /* Base styling */
body {
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #fffaf3;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

/* Login form container */
form {
  background-color: #fff8f0;
  padding: 2.5rem 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 400px;
  text-align: center;
}

/* Input fields */
form input[type="email"],
form input[type="password"] {
  width: 90%;
  padding: 0.9rem;
  margin-top: 1rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.3s;
}

form input:focus {
  border-color: #a17c5a;
}

/* Submit button */
form button {
  margin-top: 1.5rem;
  width: 95%;
  padding: 0.9rem;
  background-color: #8b5e3c;
  color: #fff;
  border: none;
  font-size: 1rem;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

form button:hover {
  background-color: #6f4323;
}

/* Error message */
.error-message {
  color: #c0392b;
  margin-top: 1rem;
  font-weight: 600;
}

</style>
</head>
<body>

<div class="login-section">
  <div class="form-container">
    <h2>Welcome Back to Crown Coffee ☕</h2>

    <?php if (!empty($error)): ?>
      <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
        <input name="email" type="email" placeholder="Email Address" required />
        <input name="password" type="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <p style="margin-top: 1rem; font-size: 0.95rem;">
      Don't have an account?
      <a href="register.php" style="color:#6b4226; font-weight: bold;">Register here</a>
    </p>
  </div>
</div>

</body>
</html>
