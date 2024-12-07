<?php
// Transactions for September and October 2024
$transactions = [
    ['date' => '2024-09-01', 'details' => 'Sale of Paracetamol', 'amount' => 200],
    ['date' => '2024-09-03', 'details' => 'Purchase of Amoxicillin', 'amount' => -150],
    ['date' => '2024-09-05', 'details' => 'Sale of Cough Syrup', 'amount' => 300],
    ['date' => '2024-09-07', 'details' => 'Purchase of Bandages', 'amount' => -100],
    ['date' => '2024-09-09', 'details' => 'Sale of Ibuprofen', 'amount' => 250],
    ['date' => '2024-09-11', 'details' => 'Purchase of Vitamin C', 'amount' => -200],
    ['date' => '2024-09-13', 'details' => 'Sale of Antiseptic', 'amount' => 350],
    ['date' => '2024-09-15', 'details' => 'Purchase of Insulin', 'amount' => -300],
    ['date' => '2024-09-17', 'details' => 'Sale of Aspirin', 'amount' => 150],
    ['date' => '2024-09-19', 'details' => 'Purchase of Cough Syrup', 'amount' => -120],
    ['date' => '2024-09-21', 'details' => 'Sale of Paracetamol', 'amount' => 200],
    ['date' => '2024-09-23', 'details' => 'Purchase of Bandages', 'amount' => -50],
    ['date' => '2024-09-25', 'details' => 'Sale of Vitamin C', 'amount' => 400],
    ['date' => '2024-09-27', 'details' => 'Purchase of Amoxicillin', 'amount' => -250],
    ['date' => '2024-09-29', 'details' => 'Sale of Antiseptic', 'amount' => 300],
    ['date' => '2024-10-01', 'details' => 'Sale of Cough Syrup', 'amount' => 275],
    ['date' => '2024-10-03', 'details' => 'Purchase of Ibuprofen', 'amount' => -200],
    ['date' => '2024-10-05', 'details' => 'Sale of Aspirin', 'amount' => 180],
    ['date' => '2024-10-07', 'details' => 'Purchase of Insulin', 'amount' => -320],
    ['date' => '2024-10-09', 'details' => 'Sale of Paracetamol', 'amount' => 225],
    ['date' => '2024-10-11', 'details' => 'Purchase of Bandages', 'amount' => -90],
    ['date' => '2024-10-13', 'details' => 'Sale of Ibuprofen', 'amount' => 260],
    ['date' => '2024-10-15', 'details' => 'Purchase of Vitamin C', 'amount' => -150],
    ['date' => '2024-10-17', 'details' => 'Sale of Antiseptic', 'amount' => 325],
    ['date' => '2024-10-19', 'details' => 'Purchase of Cough Syrup', 'amount' => -170],
    ['date' => '2024-10-21', 'details' => 'Sale of Aspirin', 'amount' => 190],
    ['date' => '2024-10-23', 'details' => 'Purchase of Insulin', 'amount' => -220],
    ['date' => '2024-10-25', 'details' => 'Sale of Vitamin C', 'amount' => 310],
    ['date' => '2024-10-27', 'details' => 'Purchase of Amoxicillin', 'amount' => -280],
    ['date' => '2024-10-29', 'details' => 'Sale of Paracetamol', 'amount' => 240],
];

// Initialize variables
$filteredTransactions = [];
$startDate = $endDate = "";

// Filter transactions based on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';

    if ($startDate && $endDate) {
        foreach ($transactions as $transaction) {
            if ($transaction['date'] >= $startDate && $transaction['date'] <= $endDate) {
                $filteredTransactions[] = $transaction;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Reports</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4caf50, #2a9d8f);
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #4caf50;
            margin-bottom: 20px;
        }
        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .input-group div {
            flex: 1;
            margin: 0 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #45a049;
        }
        #reportResults {
            margin-top: 20px;
        }
        .report-item {
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .report-item p {
            margin: 5px 0;
        }
        .report-item strong {
            color: #2a9d8f;
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaction Reports</h2>
        <form method="POST">
            <div class="input-group">
                <div>
                    <label for="startDate">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>" required>
                </div>
                <div>
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>" required>
                </div>
            </div>
            <button class="btn" type="submit">View Records</button>
        </form>

    <div id="reportResults">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if (empty($filteredTransactions)): ?>
            <p style="color: red;">No transactions found for the selected date range.</p>
        <?php else: ?>
            <?php foreach ($filteredTransactions as $transaction): ?>
                <div class="report-item">
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($transaction['date']); ?></p>
                    <p><strong>Details:</strong> <?php echo htmlspecialchars($transaction['details']); ?></p>
                    <p><strong>Amount:</strong> ₹<?php echo htmlspecialchars($transaction['amount']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

    </div>
</body>
</html>





