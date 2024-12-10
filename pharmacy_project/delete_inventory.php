<?php
require 'db.php';

$id = $_GET['id'];
$mysqli->query("DELETE FROM inventory WHERE id = $id");

header("Location: inventory_management.php");
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Inventory</title>
</head>
<body>
    <a href="delete_inventory.php?id=<?= $id; ?>" 
       style="background-color: #e63946; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">
        Delete Product
    </a>
</body>
</html>

