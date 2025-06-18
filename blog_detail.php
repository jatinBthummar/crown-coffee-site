<?php
include 'php/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM blog WHERE post_id = $id LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "Blog post not found.";
    exit;
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($post['title']) ?> | Crown Coffee</title>
  <link rel="stylesheet" href="css/user_pannel.css" />
</head>
<body>

  <!-- Page Wrapper for Sticky Footer -->
  <div class="page-container">

    <!-- Header -->
    <header class="header">
      <div class="logo">
        <a href="index.php"><img src="images/logo.png" alt="Crown Coffee Logo" /></a>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="shop.php">Shop</a></li>
          <li><a href="cart.php">Cart</a></li>
          <li><a href="blog.php" class="active">Blog</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="logout.php">Logout</a></li>

        </ul>
      </nav>
    </header>

    <!-- Blog Detail Section -->
    <section class="blog-detail">
      <div class="blog-text">
        <h3><?= htmlspecialchars($post['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <p><small>Published on: <?= date('F j, Y', strtotime($post['published_date'])) ?></small></p>
      </div>
      <?php if ($post['image']): ?>
      <div class="blog-image">
        <img src="images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" />
      </div>
      <?php endif; ?>
    </section>

  </div>

  <!-- Footer -->
  <footer class="copyright">
    &copy; 2025 Crown Coffee. All rights reserved.
  </footer>

</body>
</html>
