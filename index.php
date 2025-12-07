<?php
include 'database.php';

$query = "SELECT products.*, categories.name AS category_name 
          FROM products 
          LEFT JOIN categories 
          ON products.category_id = categories.id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Product List</title>
</head>
<body>

<div class="navbar">
    <div class="nav-left">
        <h2>Inventory System</h2>
    </div>
    <div class="nav-right">
        <a href="index.php">Products</a>
        <a href="manage_categories.php">Categories</a>
        <a href="customers.php">Customers</a>
        <a href="orders.php">Orders</a>
    </div>
</div>

<div class="container">
    <h1>Products</h1>

    <a class="btn" href="add_product.php">Add Product</a>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td>
                <?php if($row['image_path'] && file_exists($row['image_path'])){ ?>
                    <img src="<?= $row['image_path'];?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                <?php } else { ?>
                    <span style="color: #999;">No Image</span>
                <?php } ?>
            </td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['category_name']; ?></td>
            <td><?= $row['stock']; ?></td>
            <td>₱<?= $row['price']; ?></td>
            <td>
                <a class="btn-edit" href="edit_product.php?id=<?= $row['id']; ?>">Edit</a>
                <a class="btn-delete" href="delete_product.php?id=<?= $row['id']; ?>" 
                   onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
