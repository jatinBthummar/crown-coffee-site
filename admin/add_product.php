<?php
require '../php/db.php';
require 'admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $roast_level = $_POST['roast_level'];
    $flavor_notes = $_POST['flavor_notes'];
    $category = $_POST['category'];
    $stock_quantity = $_POST['stock_quantity'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp_name, "../images/$image");

    $sql = "INSERT INTO products (name, description, price, roast_level, flavor_notes, category, stock_quantity, image_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsssis", $name, $description, $price, $roast_level, $flavor_notes, $category, $stock_quantity, $image);
    $stmt->execute();

    header("Location: view_products.php");
    exit();
}
?>

<?php include 'admin_header.php'; ?>

<div class="container">
    <h2 style="margin-bottom: 1.5rem; color: #6b4226;">Add New Product</h2>
    <form action="" method="post" enctype="multipart/form-data" class="form-container">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description" rows="3" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        
        <select name="roast_level" required>
            <option value="">Select Roast Level</option>
            <option value="Light">Light</option>
            <option value="Medium">Medium</option>
            <option value="Dark">Dark</option>
        </select>
        
        <input type="text" name="flavor_notes" placeholder="Flavor Notes" required>
        
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Light">Light</option>
            <option value="Medium">Medium</option>
            <option value="Dark">Dark</option>
        </select>
        
        <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>
        
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>
</div>

<?php include 'admin_footer.php'; ?>
