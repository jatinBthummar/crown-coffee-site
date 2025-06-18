<?php
require_once 'admin_auth.php';
include '../php/db.php';

$message = '';
$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $published_date = $_POST['published_date'];

    // Get existing image
    $result = $conn->query("SELECT image FROM blog WHERE post_id = $id");
    $oldImage = $result->fetch_assoc()['image'];

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
                if (!empty($oldImage) && file_exists("../images/" . $oldImage)) {
                    unlink("../images/" . $oldImage); // delete old image
                }
                $image = $newFileName;
            } else {
                $message = "Failed to upload new image.";
            }
        } else {
            $message = "Invalid image format.";
        }
    } else {
        $image = $oldImage;
    }

    if (empty($message)) {
        $sql = "UPDATE blog SET 
                title = '$title',
                content = '$content',
                image = '$image',
                published_date = '$published_date'
                WHERE post_id = $id";
        if ($conn->query($sql)) {
            $message = "Blog post updated successfully.";
        } else {
            $message = "Error updating: " . $conn->error;
        }
    }
}

// Fetch blog post data
$result = $conn->query("SELECT * FROM blog WHERE post_id = $id");
$post = $result->fetch_assoc();

include 'admin_header.php';
?>

<section class="dashboard">
    <h2>Edit Blog Post</h2>

    <a href="blog_manage.php" class="back-btn">← Back to Blog List</a>

    <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'success') !== false ? 'green' : 'red' ?>;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" style="max-width:600px;">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required style="width:100%;"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="8" required style="width:100%;"><?= htmlspecialchars($post['content']) ?></textarea><br><br>

        <?php if (!empty($post['image'])): ?>
            <p>Current Image:</p>
            <img src="../images/<?= $post['image'] ?>" style="height: 100px;" alt="Current Image"><br><br>
        <?php endif; ?>

        <label for="image">Change Image (optional):</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>

        <label for="published_date">Published Date:</label><br>
        <input type="date" id="published_date" name="published_date" value="<?= $post['published_date'] ?>" required><br><br>

        <button type="submit" style="background-color:#6b4226; color:white; padding:10px 20px; border:none; border-radius:6px;">Update Blog Post</button>
    </form>
</section>

<?php include 'admin_footer.php'; ?>
