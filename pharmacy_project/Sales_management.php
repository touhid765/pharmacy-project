<?php
require 'db.php';

// Fetch sales data
$result = $mysqli->query("SELECT * FROM sales");

// Handle new sale submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sale'])) {
    $date = $_POST['date'];
    $customer_id = $_POST['customer_id'];
    $medicine_name = $_POST['medicine_name'];
    $quantity = $_POST['quantity'];
    $selling_price = $_POST['selling_price'];
    $total_amount = $quantity * $selling_price;

    $mysqli->query("INSERT INTO sales (date, customer_id, medicine_name, quantity, selling_price, total_amount) 
        VALUES ('$date', '$customer_id', '$medicine_name', $quantity, $selling_price, $total_amount)");

    header("Location: sales_management.php");
    exit;
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $mysqli->query("DELETE FROM sales WHERE id = $delete_id");
    header("Location: sales_management.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
</head>
<body style="font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background: #f7f7f7; color: #333;">

    <div style="max-width: 1200px; margin: 40px auto; padding: 30px; background: #ffffff; box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1); border-radius: 10px;">
        <h2 style="text-align: center; color: #2d6a4f; font-size: 2.5em; font-weight: bold; margin-bottom: 30px;">Sales Management</h2>

        <!-- Form Section -->
        <form method="POST" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 30px; justify-content: space-between;">
            <input type="date" name="date" required style="flex: 1; min-width: 180px; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em; background: #fafafa;">
            <input type="text" name="customer_id" placeholder="Customer ID" required style="flex: 1; min-width: 180px; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em; background: #fafafa;">
            <input type="text" name="medicine_name" placeholder="Medicine Name" required style="flex: 1; min-width: 180px; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em; background: #fafafa;">
            <input type="number" name="quantity" placeholder="Quantity" required style="flex: 1; min-width: 180px; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em; background: #fafafa;">
            <input type="number" name="selling_price" placeholder="Selling Price" required style="flex: 1; min-width: 180px; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1em; background: #fafafa;">
            <button type="submit" name="add_sale" style="flex: 1; min-width: 80px; padding: 10px 18px; background: #2d6a4f; color: white; border: none; border-radius: 6px; font-size: 1em; cursor: pointer; text-align: center; transition: background 0.3s ease, transform 0.2s ease;">
            Add Sale
            </button>
         </form>

        <!-- Table Section -->
        <table style="width: 100%; border-collapse: collapse; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: #2d6a4f; color: white; text-align: left;">
                    <th style="padding: 14px; font-weight: bold;">Date</th>
                    <th style="padding: 14px; font-weight: bold;">Customer ID</th>
                    <th style="padding: 14px; font-weight: bold;">Medicine</th>
                    <th style="padding: 14px; font-weight: bold;">Quantity</th>
                    <th style="padding: 14px; font-weight: bold;">Price</th>
                    <th style="padding: 14px; font-weight: bold;">Total</th>
                    <th style="padding: 14px; font-weight: bold;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #ddd; <?= $row['id'] % 2 === 0 ? 'background: #f9f9f9;' : 'background: #f4f4f4;' ?>">
                    <td style="padding: 14px;"><?= $row['date']; ?></td>
                    <td style="padding: 14px;"><?= $row['customer_id']; ?></td>
                    <td style="padding: 14px;"><?= $row['medicine_name']; ?></td>
                    <td style="padding: 14px;"><?= $row['quantity']; ?></td>
                    <td style="padding: 14px;"><?= $row['selling_price']; ?></td>
                    <td style="padding: 14px;"><?= $row['total_amount']; ?></td>
                    <td style="padding: 14px;">
                        <a href="sales_management.php?delete_id=<?= $row['id']; ?>" style="color: white; background: #e63946; text-decoration: none; padding: 10px 15px; border-radius: 6px; transition: background 0.3s ease;">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>








