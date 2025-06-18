<?php session_start(); ?>
<?php
require_once 'php/db.php'; // Adjust path as needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Shop - Crown Coffee</title>
  <link rel="stylesheet" href="CSS/user_pannel.css" />
</head>

<body>
  <?php if (isset($_SESSION['error'])): ?>
    <div style="color:red; text-align:center; margin: 1rem;">
      <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

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
        <li><a href="blog.php">Blog</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <!-- Product Categories -->
  <section class="product-categories">
    <h2>Browse by Category</h2>
    <div class="category-buttons">
      <button class="filter-btn active" data-category="all">All</button>
      <button class="filter-btn" data-category="light">Light Roast</button>
      <button class="filter-btn" data-category="medium">Medium Roast</button>
      <button class="filter-btn" data-category="dark">Dark Roast</button>
    </div>
  </section>

  <!-- Product Listings -->
  <section class="shop-products">
    <div class="products">
    <?php
      $sql = "SELECT * FROM products ORDER BY product_id DESC";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
          $stock = (int)$product['stock_quantity'];
          $category = strtolower($product['category']);

          echo "<div class='product-card' data-category='{$category}'>";
          echo "<img src='images/{$product['image_url']}' alt='{$product['name']}' />";
          echo "<h3>{$product['name']}</h3>";
          echo "<p>\${$product['price']}</p>";

          if ($stock > 0 && $stock <= 5) {
            echo "<p style='color: red; font-weight: bold;'>Only {$stock} left in stock!</p>";
          }

          if ($stock === 0) {
            echo "<p style='color: red; font-weight: bold;'>Out of Stock</p>";
            echo "<button class='btn' disabled>Add to Cart</button>";
          } else {
            echo "<form method='POST' action='php/add_to_cart.php'>";
            echo "<input type='hidden' name='product_id' value='{$product['product_id']}'>";
            echo "<input type='hidden' name='product_name' value=\"{$product['name']}\">";
            echo "<input type='hidden' name='product_price' value='{$product['price']}'>";
            echo "<input type='hidden' name='product_image' value='{$product['image_url']}'>";
            echo "<button type='submit' class='btn'>Add to Cart</button>";
            echo "</form>";
          }

          echo "</div>";
        }
      } else {
        echo "<p>No products available.</p>";
      }
    ?>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="copyright">
      <p>Copyright © 2025 – Crown Coffee</p>
    </div>
  </footer>

  <!-- JS for Filtering -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const filterButtons = document.querySelectorAll(".filter-btn");
      const productCards = document.querySelectorAll(".product-card");

      filterButtons.forEach(button => {
        button.addEventListener("click", () => {
          const selectedCategory = button.getAttribute("data-category");

          // Set active button
          filterButtons.forEach(btn => btn.classList.remove("active"));
          button.classList.add("active");

          // Filter products
          productCards.forEach(card => {
            const cardCategory = card.getAttribute("data-category");
            if (selectedCategory === "all" || selectedCategory === cardCategory) {
              card.style.display = "block";
            } else {
              card.style.display = "none";
            }
          });
        });
      });
    });
  </script>
</body>
</html>
