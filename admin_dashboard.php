<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}

// Admin username
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, <?php echo $username; ?>!</h1>
        </header>
        <nav class="dashboard-nav">
            <a href="register_car.php"><button class="btn-primary">Register Car</button></a>
            <a href="reserve_car.php"><button class="btn-primary">Reserve Car</button></a>
            <a href="search_cars.php"><button class="btn-primary">Search Cars</button></a>
            <a href="search_reservations.php"><button class="btn-primary">Search Reservations</button></a>
            <a href="generate_reports.php"><button class="btn-primary">Generate Reports</button></a>
        </nav>
        <footer class="dashboard-footer">
            <a href="admin_logout.php"><button class="btn-secondary">Logout</button></a>
        </footer>
    </div>
</body>
</html>
