<?php
session_start();
$conn = new mysqli("localhost:3309", "root", "", "pharmacy");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pharmacists WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['isAdmin'] = $user['username'] === 'admin';
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page or login page
    exit();
}

// Handle registration
if (isset($_POST['register'])) {
    if ($_SESSION['isAdmin']) {
        $newUsername = $_POST['newUsername'];
        $newPassword = $_POST['newPassword'];
        $newTimetable = $_POST['newTimetable'];

        $stmt = $conn->prepare("INSERT INTO pharmacists (username, password, timetable) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $newUsername, $newPassword, $newTimetable);
        if ($stmt->execute()) {
            echo "<script>alert('Pharmacist registered successfully!');</script>";
        } else {
            echo "<script>alert('Error registering pharmacist.');</script>";
        }
    } else {
        echo "<script>alert('Only admin can register new pharmacists.');</script>";
    }
}

// Handle delete
if (isset($_POST['delete'])) {
    if ($_SESSION['isAdmin']) {
        $deleteUsername = $_POST['deleteUsername'];

        $stmt = $conn->prepare("DELETE FROM pharmacists WHERE username = ?");
        $stmt->bind_param("s", $deleteUsername);
        if ($stmt->execute()) {
            echo "<script>alert('Pharmacist deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting pharmacist.');</script>";
        }
    } else {
        echo "<script>alert('Only admin can delete pharmacists.');</script>";
    }
}

// Fetch all pharmacists
$pharmacists = [];
$result = $conn->query("SELECT * FROM pharmacists");
while ($row = $result->fetch_assoc()) {
    $pharmacists[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="user_management.css">
</head>
<body>
    <header>
        <h1>User Management</h1>
        <nav><a href="landing_page.php">Home</a></nav>
    </header>
    <main>
        <!-- Login Section -->
        <section class="bubble">
            <h2>Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </section>

        <?php if (isset($_SESSION['username'])): ?>
            <section class="bubble">
                <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

                <!-- Pharmacist Timetable Section -->
                <section id="timetableSection">
                    <h3>Pharmacist Timetable</h3>
                    <?php
                        $loggedInUser = $_SESSION['username'];
                        $stmt = $conn->prepare("SELECT timetable FROM pharmacists WHERE username = ?");
                        $stmt->bind_param("s", $loggedInUser);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $user = $result->fetch_assoc();
                        echo "<p>{$user['timetable']}</p>";
                    ?>
                </section>

                <!-- Pharmacist Attendance Section -->
                <section id="attendanceSection">
                    <h3>Attendance</h3>
                    <form method="POST">
                        <button type="submit" name="markAttendance">Mark Attendance</button>
                    </form>
                    <?php
                    if (isset($_POST['markAttendance'])) {
                        $stmt = $conn->prepare("UPDATE pharmacists SET attendance = 1 WHERE username = ?");
                        $stmt->bind_param("s", $loggedInUser);
                        $stmt->execute();
                        echo "<p>Attendance marked for today!</p>";
                    }
                    ?>
                </section>

                <?php if ($_SESSION['isAdmin']): ?>
                    <form method="POST">
                        <h3>Register Pharmacist</h3>
                        <input type="text" name="newUsername" placeholder="New Pharmacist Username" required>
                        <input type="password" name="newPassword" placeholder="New Pharmacist Password" required>
                        <input type="text" name="newTimetable" placeholder="New Pharmacist Timetable" required>
                        <button type="submit" name="register">Register</button>
                    </form>

                    <h3>Delete Pharmacist</h3>
                    <form method="POST">
                        <select name="deleteUsername" required>
                            <option value="" disabled selected>Select Pharmacist</option>
                            <?php foreach ($pharmacists as $pharmacist): ?>
                                <?php if ($pharmacist['username'] !== 'admin'): ?>
                                    <option value="<?php echo $pharmacist['username']; ?>">
                                        <?php echo $pharmacist['username']; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="delete">Delete</button>
                    </form>
                <?php endif; ?>

                <!-- Logout Button -->
                <form method="POST" style="text-align: center; margin-top: 20px;">
                    <button type="submit" name="logout" class="logout-btn">Logout</button>
                </form>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>










