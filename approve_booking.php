<?php
// Connect to your database
$host = 'localhost'; // Default for XAMPP
$username = 'root';  // Default username for XAMPP
$password = '';      // Default password is blank
$dbname = 'booking'; // Replace with your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the booking ID from the request
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Prepare an SQL statement to update the booking approval status
    $sql = "UPDATE bookings SET approved = 1 WHERE id = ?";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId); // Bind the booking ID to the SQL statement

    // Execute the statement
    if ($stmt->execute()) {
        echo "Booking approved successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "No booking ID provided";
}

$conn->close();
?>
