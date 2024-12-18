<?php
require 'db.php';

// Fetch inventory data
$result = $mysqli->query("SELECT * FROM inventory");

// Handle new product submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $stock_in = $_POST['stock_in'];
    $stock_out = $_POST['stock_out'];
    $expired = $_POST['expired'];

    $mysqli->query("INSERT INTO inventory (product_name, stock_in, stock_out, expired) VALUES ('$product_name', $stock_in, $stock_out, $expired)");

    header("Location: inventory_management.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory </title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f8fb; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 1200px; margin: 30px auto; padding: 20px; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <!-- Add New Product Form moved to the top -->
        <h3 style="text-align: center; color: #4CAF50; margin-top: 40px; font-size: 1.8em;">Add New Product</h3>
        <form method="POST" style="margin-top: 20px; display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="product_name" placeholder="Product Name" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            <input type="number" name="stock_in" placeholder="Stock In" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            <input type="number" name="stock_out" placeholder="Stock Out" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            <input type="number" name="expired" placeholder="Expired" required style="padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
            <button type="submit" style="padding: 15px; max-width: 150px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; font-size: 0.9em; cursor: pointer; transition: background-color 0.3s ease; display: inline-block; width: auto;">
            Add Product
           </button>
        </form>
        
        <!-- Inventory Table -->
        <h2 style="text-align: center; color: #4CAF50; margin-bottom: 20px; font-size: 2em; font-weight: bold;">Inventory </h2>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr style="background-color: #4CAF50; color: white;">
                    <th style="padding: 12px; text-align: left;">#</th>
                    <th style="padding: 12px; text-align: left;">Product Name</th>
                    <th style="padding: 12px; text-align: left;">Stock In</th>
                    <th style="padding: 12px; text-align: left;">Stock Out</th>
                    <th style="padding: 12px; text-align: left;">Expired</th>
                    <th style="padding: 12px; text-align: left;">Stock Available</th>
                    <th style="padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #ddd; <?= ($row['id'] % 2 === 0) ? 'background-color: #eef7f1;' : 'background-color: #f9f9f9;' ?>">
                    <td style="padding: 10px;"><?= $row['id']; ?></td>
                    <td style="padding: 10px;"><?= $row['product_name']; ?></td>
                    <td style="padding: 10px;"><?= $row['stock_in']; ?></td>
                    <td style="padding: 10px;"><?= $row['stock_out']; ?></td>
                    <td style="padding: 10px;"><?= $row['expired']; ?></td>
                    <td style="padding: 10px;"><?= $row['stock_in'] - $row['stock_out'] - $row['expired']; ?></td>
                    <td style="padding: 10px;">
                        <a href="update_inventory.php?id=<?= $row['id']; ?>" style="color: #4CAF50; text-decoration: none; padding: 6px 12px; border: 1px solid #4CAF50; border-radius: 4px; transition: all 0.3s ease;">Update</a>
                        <a href="delete_inventory.php?id=<?= $row['id']; ?>" style="color: white; background-color: #e63946; text-decoration: none; padding: 6px 12px; border: 1px solid #e63946; border-radius: 4px; transition: all 0.3s ease;">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>





