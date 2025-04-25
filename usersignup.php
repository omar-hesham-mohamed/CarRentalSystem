<?php
require 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (!preg_match("/^[0-9]{1,10}$/", $phone)) {
        die("Phone number must be between 1-10 digits.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    if (strlen($password) < 4) {
        die("Password must be at least 4 characters long.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email exists
    $checkEmail = "SELECT * FROM Customer WHERE Email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email already exists.");
    } else {
        // Insert new user
        $sql = "INSERT INTO Customer (Name, Email, Phone, Address, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: index.html?usersignup=success");
            exit;
        } else {
            die("Error: " . $stmt->error);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
