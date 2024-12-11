<?php
require 'db.php';

// Fetch customer data
$result = $mysqli->query("SELECT * FROM customers");

// Handle new customer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $purchased_medicines = $_POST['purchased_medicines'];
    $discount = $_POST['discount'];
    $total_amount = $_POST['total_amount'];
    $paid_status = $_POST['paid_status'];

    $stmt = $mysqli->prepare("INSERT INTO customers (name, phone_number, purchased_medicines, discount, total_amount, paid_status) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdds", $name, $phone_number, $purchased_medicines, $discount, $total_amount, $paid_status);
    $stmt->execute();

    header("Location: customer_management.php");
    exit;
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $mysqli->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    header("Location: customer_management.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <link rel="stylesheet" href="customer_management.css">
    <script>
        function printBill(recordId) {
            const billElement = document.getElementById(`record-${recordId}`);
            const printWindow = window.open('', '_blank', 'width=800,height=600');

            // Clone the billElement to exclude buttons
            const cloneBill = billElement.cloneNode(true);
            const actions = cloneBill.querySelector('.actions');
            if (actions) actions.remove(); // Remove action buttons from the clone

            printWindow.document.write('<html><head><title>Bill</title></head><body>');
            printWindow.document.write(cloneBill.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Add Customer Form -->
        <div class="left-side">
            <h1>Add Customer</h1>
            <form method="POST">
                <input type="text" name="name" placeholder="Customer Name" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="text" name="purchased_medicines" placeholder="Purchased Medicines" required>
                <input type="number" name="discount" placeholder="Discount" required>
                <input type="number" name="total_amount" placeholder="Total Amount" required>
                <select name="paid_status" required>
                    <option value="" disabled selected>Paid Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
                </select>
                <button type="submit" name="add_customer">Add Customer</button>
            </form>
        </div>

        <!-- Bills Section -->
        <div class="right-side">
            <h2>Bills</h2>
            <div id="customerRecords">
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="record" id="record-<?= $row['id']; ?>">
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['name']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone_number']); ?></p>
                    <p><strong>Medicines:</strong> <?= htmlspecialchars($row['purchased_medicines']); ?></p>
                    <p><strong>Discount:</strong> <?= htmlspecialchars($row['discount']); ?></p>
                    <p><strong>Total Amount:</strong> ₹<?= htmlspecialchars($row['total_amount']); ?></p>
                    <p><strong>Paid Status:</strong> <?= htmlspecialchars($row['paid_status']); ?></p>
                    <div class="actions">
                        <!-- Delete Button -->
                        <a href="customer_management.php?delete_id=<?= $row['id']; ?>" style="padding: 8px 12px; border-radius: 4px; background-color: #e63946; color: white; text-decoration: none; cursor: pointer;">Delete</a>
                        <!-- Print Button -->
                        <button onclick="printBill(<?= $row['id']; ?>)" style="margin-left: 10px; padding: 8px 12px; border-radius: 4px; background-color: #007BFF; color: white; border: none; cursor: pointer;">Print</button>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>








