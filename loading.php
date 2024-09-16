<?php
session_start();
// Assuming booking ID is stored in the session after booking
$booking_id = isset($_SESSION['booking_id']) ? $_SESSION['booking_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Screen</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .loading-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            height: 100%;
            width: 100%;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 8px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        p {
            margin-top: 15px;
            color: #3498db;
            font-size: 16px;
            font-weight: bold;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loading-screen" id="loadingScreen">
        <div class="spinner"></div>
        <p>Booking in progress...</p>
    </div>

    <script>
        // Pass PHP booking ID to JavaScript
        const bookingId = '<?php echo $booking_id; ?>'; // This will now have the booking ID

        function checkBookingStatus() {
            // AJAX request to PHP script
            fetch(`check_status.php?booking_id=${bookingId}`)
                .then(response => response.text()) // Log the raw response first
                .then(text => {
                    console.log('Raw response:', text); // Log the raw response for debugging
                    return JSON.parse(text); // Then try to parse it as JSON
                })
                .then(data => {
                    if (data.status === 'approved') {
                        document.getElementById('loadingScreen').style.display = 'none';
                        window.location.href = 'receipt.html'; 
                    } else if (data.status === 'error') {
                        document.getElementById('loadingScreen').style.display = 'none';
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Check the status every 5 seconds
        setInterval(checkBookingStatus, 5000);
    </script>
</body>
</html>
