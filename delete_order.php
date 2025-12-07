<?php
include 'database.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: orders.php");
exit();
?>
