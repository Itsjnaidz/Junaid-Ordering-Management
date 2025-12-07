<?php
include 'database.php';
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = mysqli_fetch_assoc($result);
$stmt->close();

$categories = mysqli_query($conn,"SELECT * FROM categories");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $image_path = $product['image_path'];

    if(isset($_FILES['product_image']) && $_FILES['product_image']['size'] > 0){
        $target_dir = "uploads/";
        
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES['product_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

        if(in_array($file_ext, $allowed_ext)){
            $new_file_name = time() . '_' . rand(1000, 9999) . '.' . $file_ext;
            $target_file = $target_dir . $new_file_name;

            if(move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)){
                if($product['image_path'] && file_exists($product['image_path'])){
                    unlink($product['image_path']);
                }
                $image_path = $target_file;
            }
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock=?, category_id=?, image_path=? WHERE id=?");
    $stmt->bind_param("sddisi", $name, $price, $stock, $category_id, $image_path, $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Product</title>
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
    <h1>Edit Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']);?>" required>

        <label>Price</label>
        <input type="number" name="price" step="0.01" value="<?= $product['price'];?>" required>

        <label>Stock</label>
        <input type="number" name="stock" step="0.01" value="<?= $product['stock'];?>" required>

        <label>Category</label>
        <select name="category_id" required>
            <?php while($cat=mysqli_fetch_assoc($categories)){ ?>
            <option value="<?= $cat['id'];?>" <?= $product['category_id']==$cat['id']?'selected':'';?>>
                <?= htmlspecialchars($cat['name']);?>
            </option>
            <?php } ?>
        </select>

        <label>Product Image</label>
        <?php if($product['image_path'] && file_exists($product['image_path'])){ ?>
            <div style="margin-bottom: 15px;">
                <img src="<?= $product['image_path'];?>" style="max-width: 200px; border-radius: 8px;">
                <p><small>Current Image</small></p>
            </div>
        <?php } ?>
        <input type="file" name="product_image" accept="image/*">
        <small>Leave empty to keep current image</small>

        <button class="btn" name="submit" type="submit">Update Product</button>
        <a class="btn" href="index.php">Back</a>
    </form>
</div>

</body>
</html>
