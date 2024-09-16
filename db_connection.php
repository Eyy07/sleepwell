<?php
// Start output buffering to prevent accidental output
ob_start();

try {
    // Correct the database name, username, and password
    $pdo = new PDO('mysql:host=localhost;dbname=bookings', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, output an error message as JSON
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
    exit(); // Stop script execution if connection fails
}

// End output buffering
ob_end_flush();
?>
