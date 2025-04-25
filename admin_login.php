<?php
session_start();
require 'db.php'; // Database connection

// Check if the user is logged in
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username exists
    $sql = "SELECT * FROM Admin WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admin found, check password (plain text comparison)
        $admin = $result->fetch_assoc();

        // Compare plain text password
        if ($password === $admin['Password']) {
            // Set session and redirect to admin dashboard
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['username'] = $admin['Username'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";  // Password doesn't match
        }
    } else {
        $error = "No such username found.";  // Username doesn't exist
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <div class="form-container">
            <!-- Display error message if username or password is incorrect -->
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="admin_login.php" method="POST">
                <label>Username:</label>
                <input type="text" name="username" required />
                <label>Password:</label>
                <input type="password" name="password" required />
                <button type="submit" class="btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
