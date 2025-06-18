<?php
require '../php/db.php';
require 'admin_auth.php';

/* ---------- delete ---------- */
if (isset($_GET['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $_GET['delete_id']);
    $stmt->execute();
    header("Location: view_products.php");
    exit();
}

/* ---------- filter ---------- */
$isOut = isset($_GET['out_of_stock']) && $_GET['out_of_stock'] == 1;
if ($isOut) {
    $sql = "SELECT * FROM products WHERE stock_quantity = 0 ORDER BY product_id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY product_id DESC";
}
$result = $conn->query($sql);
?>
<?php include 'admin_header.php'; ?>

<h2>View Products</h2>
<?php if ($isOut): ?>
  <p><a href="view_products.php" style="color:#6b4226;font-weight:bold;">← Back to all products</a></p>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%;border-collapse:collapse;">
  <thead>
    <tr>
      <th>ID</th><th>Image</th><th>Name</th><th>Description</th>
      <th>Price</th><th>Roast</th><th>Flavor</th><th>Category</th><th>Stock</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows === 0): ?>
      <tr>
        <td colspan="10" style="text-align:center;color:red;">
          <?= $isOut ? 'There are no out‑of‑stock products.' : 'No products found.' ?>
        </td>
      </tr>
    <?php endif; ?>

    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['product_id'] ?></td>
        <td>
          <?php if ($row['image_url']): ?>
            <img src="../images/<?= htmlspecialchars($row['image_url']) ?>" width="70">
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>$<?= number_format($row['price'],2) ?></td>
        <td><?= htmlspecialchars($row['roast_level']) ?></td>
        <td><?= htmlspecialchars($row['flavor_notes']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= (int)$row['stock_quantity'] ?></td>
        <td>
          <a href="edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> |
          <a href="view_products.php?delete_id=<?= $row['product_id'] ?>&<?= $isOut?'out_of_stock=1':'' ?>"
             onclick="return confirm('Delete this product?');">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'admin_footer.php'; ?>
