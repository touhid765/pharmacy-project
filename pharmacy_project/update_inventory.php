<?php
require 'db.php';

$id = $_GET['id'];

// Fetch inventory data for the given ID
$result = $mysqli->query("SELECT * FROM inventory WHERE id = $id");
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $stock_in = $_POST['stock_in'];
    $stock_out = $_POST['stock_out'];
    $expired = $_POST['expired'];

    $mysqli->query("UPDATE inventory SET product_name = '$product_name', stock_in = $stock_in, stock_out = $stock_out, expired = $expired WHERE id = $id");

    header("Location: inventory_management.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Inventory</title>
</head>
<body>
    <h2>Update Product</h2>
    <form method="POST">
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>" required>
        <input type="number" name="stock_in" value="<?= htmlspecialchars($product['stock_in']); ?>" required>
        <input type="number" name="stock_out" value="<?= htmlspecialchars($product['stock_out']); ?>" required>
        <input type="number" name="expired" value="<?= htmlspecialchars($product['expired']); ?>" required>
        <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Update Product
        </button>
    </form>
</body>
</html>

