<?php
session_start();
$conn = new mysqli("localhost:3309", "root", "", "pharmacy");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['isAdmin'])) {
    $_SESSION['isAdmin'] = false;
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = null;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pharmacists WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['isAdmin'] = ($user['username'] === 'admin');
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location:reporting.php");
    exit;
}

if (isset($_POST['addTransaction']) && !$_SESSION['isAdmin']) {
    $date = $_POST['date'];
    $details = $_POST['details'];
    $amount = $_POST['amount'];
    $pharmacist_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO transactions (pharmacist_id, date, details, amount) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $pharmacist_id, $date, $details, $amount);

    if ($stmt->execute()) {
        echo "<script>alert('Transaction added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding transaction.');</script>";
    }
}

if (isset($_POST['approveTransaction']) && $_SESSION['isAdmin']) {
    $transaction_id = $_POST['transaction_id'];

    $stmt = $conn->prepare("UPDATE transactions SET status = 'Approved' WHERE id = ?");
    $stmt->bind_param("i", $transaction_id);

    if ($stmt->execute()) {
        echo "<script>alert('Transaction approved!');</script>";
    } else {
        echo "<script>alert('Error approving transaction.');</script>";
    }
}

$transactions = [];
if ($_SESSION['isAdmin']) {
    $result = $conn->query("SELECT t.*, p.username FROM transactions t JOIN pharmacists p ON t.pharmacist_id = p.id");
    if ($result) {
        $transactions = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $transactions = [];
    }
} else if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE pharmacist_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Reporting</title>
    <link rel="stylesheet" href="reporting.css">
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['username'])): ?>
            <h2>Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button class="btn" type="submit" name="login">Login</button>
            </form>
        <?php else: ?>
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
            <?php if ($_SESSION['isAdmin']): ?>
                <h3>All Transactions</h3>
                <?php foreach ($transactions as $transaction): ?>
                    <div class="transaction-item">
                        <p><strong>Date:</strong> <?php echo $transaction['date']; ?></p>
                        <p><strong>Details:</strong> <?php echo $transaction['details']; ?></p>
                        <p><strong>Amount:</strong> ₹<?php echo $transaction['amount']; ?></p>
                        <p><strong>Pharmacist:</strong> <?php echo $transaction['username']; ?></p>
                        <p><strong>Status:</strong> <?php echo $transaction['status']; ?></p>
                        <?php if ($transaction['status'] === 'Pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                                <button class="btn" type="submit" name="approveTransaction">Approve</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h3>Add Transaction</h3>
                <form method="POST">
                    <input type="date" name="date" required>
                    <textarea name="details" placeholder="Transaction details" required></textarea>
                    <input type="number" name="amount" step="0.01" placeholder="Amount (₹)" required>
                    <button class="btn" type="submit" name="addTransaction">Add Transaction</button>
                </form>
            <?php endif; ?>
            <div class="logout-section">
                <form method="POST">
                    <button class="btn" type="submit" name="logout">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>











