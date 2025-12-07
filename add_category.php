<?php
include 'database.php';
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    $stmt->close();
    
    header("Location: manage_categories.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Add Category</title>
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
    <h1>Add Category</h1>
    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" required>
        <label>Description</label>
        <textarea name="description" required></textarea>
        <button class="btn" name="submit" type="submit">Add Category</button>
        <a class="btn" href="manage_categories.php">Back</a>
    </form>
</div>

</body>
</html>
