<?php
require '../php/db.php';
require 'admin_auth.php';

if (!isset($_GET['id'])) {
    header("Location: view_products.php");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit();
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $roast_level = $_POST['roast_level'];
    $flavor_notes = $_POST['flavor_notes'];
    $category = $_POST['category'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload if new image provided
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../images/$image");

        $sql = "UPDATE products SET name=?, description=?, price=?, roast_level=?, flavor_notes=?, category=?, stock_quantity=?, image_url=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsssis", $name, $description, $price, $roast_level, $flavor_notes, $category, $stock_quantity, $image, $product_id);
    } else {
        $sql = "UPDATE products SET name=?, description=?, price=?, roast_level=?, flavor_notes=?, category=?, stock_quantity=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsssii", $name, $description, $price, $roast_level, $flavor_notes, $category, $stock_quantity, $product_id);
    }

    $stmt->execute();
    header("Location: view_products.php");
    exit();
}
?>

<?php include 'admin_header.php'; ?>

<div class="container">
    <h2>Edit Product</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

        <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br>

        <input type="number" step="0.01" name="price" placeholder="Price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

        <input type="text" name="roast_level" placeholder="Roast Level" value="<?php echo htmlspecialchars($product['roast_level']); ?>" required><br>

        <input type="text" name="flavor_notes" placeholder="Flavor Notes" value="<?php echo htmlspecialchars($product['flavor_notes']); ?>" required><br>

        <select name="category" required>
            <option value="Light" <?php if($product['category']=='Light') echo 'selected'; ?>>Light</option>
            <option value="Medium" <?php if($product['category']=='Medium') echo 'selected'; ?>>Medium</option>
            <option value="Dark" <?php if($product['category']=='Dark') echo 'selected'; ?>>Dark</option>
        </select><br>

        <input type="number" name="stock_quantity" placeholder="Stock Quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required><br>

        <label>Current Image:</label><br>
        <img src="../images/<?php echo htmlspecialchars($product['image_url']); ?>" width="100" alt="Product Image"><br>

        <label>Change Image (optional):</label><br>
        <input type="file" name="image" accept="image/*"><br>

        <button type="submit">Update Product</button>
    </form>
</div>

<?php include 'admin_footer.php'; ?>
