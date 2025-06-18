<?php
include 'php/db.php';

$sql = "SELECT * FROM blog ORDER BY published_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crown Coffee | Blog</title>
  <link rel="stylesheet" href="css/user_pannel.css" />
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo">
      <a href="index.php">
        <img src="images/logo.png" alt="Crown Coffee Logo" />
      </a>
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

  <!-- Blog Section -->
  <section class="blog-section">
    <h2>Coffee Culture & Brewing Tips</h2>
    <div class="blog-posts">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <article class="blog-card">
            <?php
              $imagePath = 'images/' . htmlspecialchars($row['image']);
              if (!empty($row['image']) && file_exists($imagePath)):
            ?>
              <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['title']) ?>" />
            <?php else: ?>
              <img src="images/blog_placeholder.jpg" alt="No image available" />
            <?php endif; ?>
            <div class="blog-content">
              <h3><?= htmlspecialchars($row['title']) ?></h3>
              <p><?= nl2br(htmlspecialchars(substr($row['content'], 0, 150))) ?>...</p>
              <a href="blog_detail.php?id=<?= $row['post_id'] ?>" class="read-more">Read More</a>
            </div>
          </article>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No blog posts available.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="copyright">
    &copy; 2025 Crown Coffee. All rights reserved.
  </footer>

</body>
</html>
