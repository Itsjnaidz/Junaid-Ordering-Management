<?php
include 'database.php';
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM customers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = mysqli_fetch_assoc($result);
$stmt->close();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: customers.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Customer</title>
</head>
<body>

<div class="navbar">
    <div class="nav-left"><h2>Inventory System</h2></div>
    <div class="nav-right">
        <a href="index.php">Products</a>
        <a href="manage_categories.php">Categories</a>
        <a href="customers.php">Customers</a>
        <a href="orders.php">Orders</a>
    </div>
</div>

<div class="container">
    <h1>Edit Customer</h1>
    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($customer['name']);?>" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($customer['email']);?>" required>
        <button class="btn" name="submit" type="submit">Update Customer</button>
        <a class="btn" href="customers.php">Back</a>
    </form>
</div>

</body>
</html>
