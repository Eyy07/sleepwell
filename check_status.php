<?php
// Start output buffering to prevent accidental output
ob_start();

// Include database connection
include 'db_connection.php';

// Set content-type to JSON
header('Content-Type: application/json');

// Check if booking_id is provided
if (!isset($_GET['booking_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Booking ID is required']);
    exit();
}

$booking_id = $_GET['booking_id'];

try {
    // Fetch booking status from the database
    $stmt = $pdo->prepare('SELECT status FROM bookings WHERE id = :booking_id');
    $stmt->execute(['booking_id' => $booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        $response = [
            'status' => $booking['status'], // e.g., 'approved', 'pending', 'rejected'
            'message' => 'Booking status retrieved successfully'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No booking found for this ID'
        ];
    }
} catch (PDOException $e) {
    // Handle database errors
    $response = [
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ];
}

// Output JSON response
echo json_encode($response);
ob_end_flush(); // End output buffering and send the output
?>
