<?php
require_once 'admin_auth.php';
include '../php/db.php';

$sql = "SELECT * FROM blog ORDER BY published_date DESC";
$result = $conn->query($sql);

include 'admin_header.php';
?>

<section class="dashboard">
    <h2>Manage Blog Posts</h2>
    <a href="admin_add_blog.php" class="btn add-user-btn">+ Add New Post</a><br><br>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Published Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php if (!empty($row['image']) && file_exists('../images/' . $row['image'])): ?>
                            <img src="../images/<?= $row['image'] ?>" alt="Thumbnail" style="height: 50px;">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['published_date']) ?></td>
                    <td>
                        <a href="blog_edit.php?id=<?= $row['post_id'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="blog_delete.php?id=<?= $row['post_id'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No blog posts found.</p>
    <?php endif; ?>
</section>

<?php include 'admin_footer.php'; ?>
