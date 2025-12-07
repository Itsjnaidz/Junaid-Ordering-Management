<?php
include 'database.php';
$result = mysqli_query($conn,"SELECT * FROM customers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Customers</title>
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
    <h1>Customers</h1>
    <a class="btn" href="add_customer.php">Add Customer</a>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($row=mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['id'];?></td>
            <td><?= $row['name'];?></td>
            <td><?= $row['email'];?></td>
            <td>
                <a class="btn-edit" href="edit_customer.php?id=<?= $row['id'];?>">Edit</a>
                <a class="btn-delete" href="delete_customer.php?id=<?= $row['id'];?>" 
                   onclick="return confirm('Delete this customer?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
