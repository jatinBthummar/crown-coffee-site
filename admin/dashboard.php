<?php
require_once 'admin_auth.php';
include '../php/db.php';

/* ----------  helper for safe counts ---------- */
function getCount(mysqli $c, string $sql): int {
    $res = $c->query($sql);
    if (!$res) { die("DB error: ".$c->error); }
    $row = $res->fetch_assoc();
    return (int) ($row['total'] ?? 0);
}

/* ----------  counts for the cards ---------- */
$totalProducts = getCount($conn, "SELECT COUNT(*) AS total FROM products");
$totalOrders   = getCount($conn, "SELECT COUNT(*) AS total FROM orders");
$pendingOrders = getCount($conn, "SELECT COUNT(*) AS total FROM orders WHERE order_status = 'pending'");
$totalUsers    = getCount($conn, "SELECT COUNT(*) AS total FROM users");
$outOfStock    = getCount($conn, "SELECT COUNT(*) AS total FROM products WHERE stock_quantity = 0");

/* ----------  product list for table ---------- */
$products = $conn->query("SELECT * FROM products ORDER BY product_id DESC");
?>
<?php include 'admin_header.php'; ?>

<main class="main-content container">
  <h1 class="dashboard-welcome">Welcome, Admin!</h1>

  <!-- ======= STAT CARDS ======= -->
  <div class="dashboard-grid">
    <a href="view_products.php"                 class="dashboard-card">
      <h3>Total Products</h3><p class="stat-number"><?= $totalProducts ?></p><p>Active products</p>
    </a>
    <a href="view_orders.php"                   class="dashboard-card">
      <h3>Total Orders</h3><p class="stat-number"><?= $totalOrders ?></p><p>All orders</p>
    </a>
    <a href="view_orders.php?status=pending"    class="dashboard-card">
      <h3>Pending Orders</h3><p class="stat-number"><?= $pendingOrders ?></p><p>Awaiting processing</p>
    </a>
    <a href="manage_users.php"                  class="dashboard-card">
      <h3>Users</h3><p class="stat-number"><?= $totalUsers ?></p><p>Registered customers</p>
    </a>
    <a href="view_products.php?out_of_stock=1"  class="dashboard-card">
      <h3>Out of Stock</h3><p class="stat-number"><?= $outOfStock ?></p><p>Need restock</p>
    </a>
  </div>

  <!-- ======= PRODUCT TABLE ======= -->
  <section class="dashboard" style="margin-top:3rem;">
    <h2>Manage Products</h2>

    <?php if ($products && $products->num_rows): ?>
      <table style="width:100%;border-collapse:collapse;">
        <thead style="background:#865139;color:#fff;">
          <tr>
            <th>ID</th><th>Name</th><th>Category</th><th>Price ($)</th>
            <th>Stock</th><th>Image</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $products->fetch_assoc()): ?>
          <tr>
            <td style="text-align:center;"><?= $row['product_id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td style="text-align:center;"><?= htmlspecialchars($row['category']) ?></td>
            <td style="text-align:right;"><?= number_format($row['price'],2) ?></td>
            <td style="text-align:center;
                       font-weight:<?= $row['stock_quantity']==0?'700':'400' ?>;
                       color:<?= $row['stock_quantity']==0?'#d9534f':'#333' ?>;">
               <?= (int)$row['stock_quantity'] ?>
            </td>
            <td style="text-align:center;">
              <?= $row['image_url']
                     ? '<img src="../images/'.htmlspecialchars($row['image_url']).'" style="height:50px;border-radius:6px;">'
                     : 'No image'; ?>
            </td>
            <td style="text-align:center;">
              <a href="edit_product.php?id=<?= $row['product_id'] ?>" style="background:#6b4226;color:#fff;padding:4px 10px;border-radius:6px;text-decoration:none;">Edit</a>
              <a href="delete_product.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Delete this product?');"
                 style="background:#865139;color:#fff;padding:4px 10px;border-radius:6px;text-decoration:none;">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No products found.</p>
    <?php endif; ?>
  </section>

  <div class="dashboard-actions" style="text-align:center;margin-top:2rem;">
    <a href="add_product.php">Add Product</a>
    <a href="view_orders.php">View Orders</a>
    <a href="manage_users.php">Manage Users</a>
  </div>
</main>

<?php include 'admin_footer.php'; ?>
