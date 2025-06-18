<?php
require_once 'admin_auth.php';
include '../php/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get image filename to delete from folder
    $result = $conn->query("SELECT image FROM blog WHERE post_id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        if (!empty($row['image']) && file_exists("../images/" . $row['image'])) {
            unlink("../images/" . $row['image']); // delete image
        }
    }

    $conn->query("DELETE FROM blog WHERE post_id = $id");
}

header("Location: blog_manage.php");
exit();
