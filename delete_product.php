<?php
include 'database.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image_path FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = mysqli_fetch_assoc($result);
$stmt->close();

if($product['image_path'] && file_exists($product['image_path'])){
    unlink($product['image_path']);
}

$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit();
?>
