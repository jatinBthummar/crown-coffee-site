<?php
require_once 'admin_auth.php';
include '../php/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $published_date = $_POST['published_date'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newFileName = uniqid('blog_', true) . '.' . $ext;
            $destination = "../images/" . $newFileName;

            if (move_uploaded_file($filetmp, $destination)) {
                $image = $newFileName;
            } else {
                $message = "Failed to upload image.";
            }
        } else {
            $message = "Invalid image format. Allowed: jpg, jpeg, png, gif.";
        }
    } else {
        $image = null; // no image uploaded
    }

    if (empty($message)) {
        $sql = "INSERT INTO blog (title, content, image, published_date) VALUES ('$title', '$content', " . ($image ? "'$image'" : "NULL") . ", '$published_date')";
        if ($conn->query($sql)) {
            $message = "Blog post added successfully.";
        } else {
            $message = "Database error: " . $conn->error;
        }
    }
}

include 'admin_header.php';
?>

<section class="dashboard">
    <h2>Add New Blog Post</h2>
    <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'success') !== false ? 'green' : 'red' ?>;"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data" style="max-width:600px;">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required style="width:100%;"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="8" required style="width:100%;"></textarea><br><br>

        <label for="image">Image (optional):</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>

        <label for="published_date">Published Date:</label><br>
        <input type="date" id="published_date" name="published_date" required><br><br>

        <button type="submit" style="background-color:#6b4226; color:white; padding:10px 20px; border:none; border-radius:6px;">Add Blog Post</button>
    </form>
</section>

<?php include 'admin_footer.php'; ?>
