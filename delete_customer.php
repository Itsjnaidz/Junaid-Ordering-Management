<?php
include 'database.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: customers.php");
exit();
?>
