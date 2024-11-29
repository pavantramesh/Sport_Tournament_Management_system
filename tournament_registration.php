<?php
include 'admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $tournament_id = $_POST['tournament_id'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($tournament_id)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL query to insert registration data
    $stmt = $conn->prepare("INSERT INTO tournament_registration (tournament_id, name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $tournament_id, $name, $email, $phone);

    // Execute query
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
