<?php
require_once 'admin_auth.php';
require_once '../php/db.php';

$sql = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);

include 'admin_header.php';
?>

<section class="container main-content">
    <h2>Contact Messages</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #865139; color: white;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($msg = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $msg['id'] ?></td>
                        <td><?= htmlspecialchars($msg['name']) ?></td>
                        <td><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                        <td><?= $msg['submitted_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No contact messages found.</p>
    <?php endif; ?>
</section>

<?php include 'admin_footer.php'; ?>
