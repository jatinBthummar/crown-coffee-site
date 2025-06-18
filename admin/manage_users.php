<?php
require_once 'admin_auth.php';
include '../php/db.php';

$sql = "SELECT user_id, name, email, role FROM users ORDER BY user_id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

include 'admin_header.php';
?>

<main class="main-content container">
    <h2>Manage Users</h2>
    <?php if ($result->num_rows > 0): ?>
    <table style="width:100%; border-collapse: collapse;">
        <thead style="background-color: #865139; color: white;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="action-btn" style="background-color: #6b4226; color: white; padding: 5px 12px; border-radius: 6px; text-decoration:none; margin-right: 5px;">Edit</a>
                    <a href="delete_user.php?id=<?= $row['user_id'] ?>" class="action-btn delete" style="background-color: #865139; color: white; padding: 5px 12px; border-radius: 6px; text-decoration:none;"
                       onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No users found.</p>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="add_user.php" style="background-color:#6b4226; color:#fff; padding: 10px 20px; border-radius: 6px; text-decoration:none;">Add New User</a>
    </div>
</main>

<?php include 'admin_footer.php'; ?>
