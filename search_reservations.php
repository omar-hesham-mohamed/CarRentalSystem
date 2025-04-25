<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit;
}

require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchQuery = trim($_POST['searchQuery']);
    $sql = "SELECT r.ReservationNumber, c.Name, ca.Model, r.StartDate, r.EndDate 
            FROM Reservation r
            JOIN Customer c ON r.CustomerID = c.CustomerID
            JOIN Car ca ON r.CarID = ca.CarID
            WHERE c.Name LIKE ? OR ca.Model LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Reservations</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Search Reservations</h1>
        <form action="search_reservations.php" method="POST">
            <input type="text" name="searchQuery" placeholder="Search by customer name or car model" required />
            <button type="submit" class="btn-primary">Search</button>
        </form>

        <?php if (isset($result)): ?>
            <h2>Search Results</h2>
            <table>
                <tr>
                    <th>Reservation Number</th>
                    <th>Customer Name</th>
                    <th>Car Model</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['ReservationNumber']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Model']; ?></td>
                        <td><?php echo $row['StartDate']; ?></td>
                        <td><?php echo $row['EndDate']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
