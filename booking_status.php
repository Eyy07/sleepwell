<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Connect to database
        $conn = new mysqli('localhost', 'username', 'password', 'database');
        $id = intval($_GET['id']);
        $result = $conn->query("SELECT status FROM bookings WHERE id=$id");
        $row = $result->fetch_assoc();

        if ($row['status'] === 'approved') {
            echo "<h1>Booking Successful!</h1><p>Your booking has been approved. Thank you!</p>";
        } else {
            echo "<h1>Pending Approval</h1><p>Your booking is still pending. Please wait for admin approval.</p>";
        }
        ?>
    </div>
</body>
</html>
