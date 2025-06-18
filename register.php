<?php
require('php/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['phone']) || empty($_POST['address'])) {
        $error = "Please fill all required fields.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match('/^[0-9]{10}$/', $_POST['phone'])) {
        $error = "Phone number must be 10 digits.";
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone_number, address, role) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
        $stmt->execute();
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register</title>

<style>
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

  form {
    background-color: #fff8f0;
    padding: 2.5rem 2rem;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 420px;
    text-align: center;
  }

  form input[type="text"],
  form input[type="email"],
  form input[type="password"],
  form input[type="tel"],
  form input[type="address"] {
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

  .error-message {
    color: #c0392b;
    margin-top: 1rem;
    font-weight: 600;
  }

  ::placeholder {
    color: #a17c5a;
    opacity: 0.7;
  }

  /* Login link below the register button */
  .login-link {
    margin-top: 1rem;
    font-size: 0.95rem;
  }
  .login-link a {
    color: #6b4226;
    font-weight: bold;
    text-decoration: none;
  }
  .login-link a:hover {
    color: #4e3118;
  }
</style>

</head>
<body>

<?php if (!empty($error)): ?>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" novalidate>
    <input name="name" type="text" placeholder="Name" required />
    <input name="email" type="email" placeholder="Email" required />
    <input name="password" type="password" placeholder="Password" required />
    <input name="phone" type="tel" placeholder="Phone" required pattern="[0-9]{10}" title="Enter 10-digit phone number" />
    <input name="address" type="text" placeholder="Address" required />
    <button type="submit">Register</button>

    <p class="login-link">
      Already have an account? 
      <a href="login.php">Login here</a>
    </p>
</form>

</body>
</html>
