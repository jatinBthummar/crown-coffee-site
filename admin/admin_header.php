<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Crown Coffee</title>
    <link rel="stylesheet" href="admin_style.css" />
</head>
<body>
<header class="main-header">
  <div class="logo">
    <a href="dashboard.php" style="display: inline-block;">
      <img src="../images/logo.png" alt="Crown Coffee Logo" style="height: 50px;">
    </a>
  </div>

  <nav class="admin-nav">
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>

      <!-- Dropdown starts here -->
      <li class="dropdown">
        <a href="add_product.php">Add</a>
        <ul class="dropdown-content">
          <li><a href="add_product.php">Add Product</a></li>
          <li><a href="admin_add_blog.php">Add Blog Post</a></li>
          <li><a href="blog_manage.php">Manage Blog</a></li> 
        </ul>
      </li>

      <!-- Dropdown ends -->

      <li><a href="view_products.php">View Products</a></li>
      <li><a href="view_orders.php">View Orders</a></li>
      
      <li class="dropdown">
        <a href="contact_messages.php">Contact</a>
        <ul class="dropdown-content">
          <li><a href="contact_messages.php">Message</a></li>
          <li><a href="logout.php">LogOut</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</header>

<main class="main-content">
