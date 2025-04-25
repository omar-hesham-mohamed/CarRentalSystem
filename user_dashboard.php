<?php
session_start();
if (!isset($_SESSION['CustomerID'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, Customer!</h1>
    <a href="search_car.php"><button>Search Cars</button></a>
    <a href="reserve_car.php"><button>Reserve a Car</button></a>
</body>
</html>
