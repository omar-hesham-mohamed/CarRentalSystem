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
    $sql = "SELECT * FROM Car WHERE Model LIKE ? OR Type LIKE ? OR Status LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchQuery, $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Cars</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Search Cars</h1>
        <form action="search_cars.php" method="POST">
            <input type="text" name="searchQuery" placeholder="Search by model, type, or status" required />
            <button type="submit" class="btn-primary">Search</button>
        </form>

        <?php if (isset($result)): ?>
            <h2>Search Results</h2>
            <table>
                <tr>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Plate Number</th>
                    <th>Status</th>
                    <th>Color</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['Model']; ?></td>
                        <td><?php echo $row['Year']; ?></td>
                        <td><?php echo $row['PlateNumber']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Color']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
