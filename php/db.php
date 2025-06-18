<?php
$host = 'localhost';
$db = 'crown_coffee';
$user = 'root';
$pass = '';
mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
