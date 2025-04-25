<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}

require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerID = trim($_POST['customerID']);
    $carID = trim($_POST['carID']);
    $startDate = trim($_POST['startDate']);
    $endDate = trim($_POST['endDate']);
    $paymentStatus = trim($_POST['paymentStatus']);

    // Insert reservation into the database
    $sql = "INSERT INTO Reservation (CustomerID, CarID, StartDate, EndDate, PaymentStatus)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $customerID, $carID, $startDate, $endDate, $paymentStatus);

    if ($stmt->execute()) {
        echo "Car reserved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Car</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Reserve a Car</h1>
        <form action="reserve_car.php" method="POST">
            <label>Customer ID:</label>
            <input type="number" name="customerID" required />
            <label>Car ID:</label>
            <input type="number" name="carID" required />
            <label>Start Date:</label>
            <input type="date" name="startDate" required />
            <label>End Date:</label>
            <input type="date" name="endDate" required />
            <label>Payment Status:</label>
            <select name="paymentStatus">
                <option value="Pending">Pending</option>
                <option value="Done">Done</option>
            </select>
            <button type="submit" class="btn-primary">Reserve Car</button>
        </form>
    </div>
</body>
</html>
