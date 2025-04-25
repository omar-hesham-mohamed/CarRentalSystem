<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}

require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = trim($_POST['model']);
    $year = trim($_POST['year']);
    $plateNumber = trim($_POST['plateNumber']);
    $status = trim($_POST['status']);
    $color = trim($_POST['color']);
    $type = trim($_POST['type']);
    $numberOfSeats = trim($_POST['numberOfSeats']);

    // Insert car into the database
    $sql = "INSERT INTO Car (Model, Year, PlateNumber, Status, Color, Type, NumberOfSeats)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssis", $model, $year, $plateNumber, $status, $color, $type, $numberOfSeats);

    if ($stmt->execute()) {
        echo "Car registered successfully!";
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
    <title>Register Car</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Register New Car</h1>
        <form action="register_car.php" method="POST">
            <label>Model:</label>
            <input type="text" name="model" required />
            <label>Year:</label>
            <input type="number" name="year" required />
            <label>Plate Number:</label>
            <input type="text" name="plateNumber" required />
            <label>Status:</label>
            <select name="status">
                <option value="Available">Available</option>
                <option value="Rented">Rented</option>
                <option value="Out of Order">Out of Order</option>
            </select>
            <label>Color:</label>
            <input type="text" name="color" required />
            <label>Type:</label>
            <select name="type">
                <option value="Race">Race</option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
            </select>
            <label>Number of Seats:</label>
            <select name="numberOfSeats">
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="6">6</option>
            </select>
            <button type="submit" class="btn-primary">Register Car</button>
        </form>
    </div>
</body>
</html>
