<?php
include 'database.php';

$customers = mysqli_query($conn,"SELECT * FROM customers");
$products = mysqli_query($conn,"SELECT * FROM products");

if(isset($_POST['submit'])){
    $customer_id = $_POST['customer_id'];
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (customer_id) VALUES (?)");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $order_id = mysqli_insert_id($conn);
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    
    foreach($product_ids as $index => $prod_id){
        $qty = $quantities[$index];
        if($qty>0){
            $stmt->bind_param("iii", $order_id, $prod_id, $qty);
            $stmt->execute();
        }
    }
    $stmt->close();
    
    header("Location: orders.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Create Order</title>
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
    <h1>Create Order</h1>
    <form method="POST">
        <label>Customer</label>
        <select name="customer_id" required>
            <option value="">Select Customer</option>
            <?php while($c=mysqli_fetch_assoc($customers)){ ?>
            <option value="<?= $c['id'];?>"><?= $c['name'];?></option>
            <?php } ?>
        </select>

        <h2>Products</h2>
        <?php while($p=mysqli_fetch_assoc($products)){ ?>
            <label><?= $p['name'];?> (₱<?= $p['price'];?>)</label>
            <input type="number" name="quantity[]" placeholder="Quantity" min="0">
            <input type="hidden" name="product_id[]" value="<?= $p['id'];?>">
        <?php } ?>

        <button class="btn" type="submit" name="submit">Create Order</button>
        <a class="btn" href="orders.php">Back</a>
    </form>
</div>

</body>
</html>
