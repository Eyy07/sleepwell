<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'bookings');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Approve booking
if (isset($_GET['approve']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE bookings SET status='approved' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking approved successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch bookings
$result = $conn->query("SELECT * FROM bookings");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff </title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }
        .dark-mode {
            background-color: #333;
            color: #f5f5f5;
        }
        .hamburger {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .hamburger div {
            width: 30px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.3s;
        }
        .menu a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .menu a:hover {
            background-color: #45a049;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        h1, h2 {
            color: #333;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .form-container label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .welcome-text {
            font-size: 1.2em;
            line-height: 1.6;
        }
      /* Sidebar Menu */
.menu {
    position: fixed;
    top: 0;
    left: -250px; /* Initially hidden off-screen */
    width: 250px;
    height: 100%;
    background-color: #4CAF50;
    color: white;
    transition: left 0.3s ease;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow-y: auto; /* Allows scrolling if content overflows */
}

.menu.active {
    left: 0; /* Slide in when active */
}

/* Logo Styling */
.logo {
    text-align: center;
    margin-bottom: 20px;
}

.logo-image {
    max-width: 80%; /* Adjust to fit inside the sidebar */
    height: auto;
}

/* Theme Switcher Styling */
.theme-switch {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    color: #fff;
}

.theme-switch input {
    display: none;
}

.theme-switch label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 0.9em;
    color: #fff;
}

.theme-switch .slider {
    position: relative;
    width: 34px;
    height: 20px;
    background-color: #fff;
    border-radius: 34px;
    transition: background-color 0.3s;
}

.theme-switch .slider:before {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background-color: #4CAF50;
    transition: transform 0.3s;
}

.theme-switch input:checked + label .slider {
    background-color: #333;
}

.theme-switch input:checked + label .slider:before {
    transform: translateX(14px);
}

/* Log Out Button Styling */
.logout {
    position: absolute;
    bottom: 20px;
    left: 20px;
    width: calc(100% - 40px);
    padding: 10px 20px;
    background-color: #ff5c5c;
    border: none;
    color: white;
    cursor: pointer;
    text-align: center;
    border-radius: 4px;
}

.logout:hover {
    background-color: #ff4444;
}

    </style>
</head>
<body>
    <!-- Hamburger Menu -->
<div class="hamburger" onclick="toggleMenu()">
    <div></div>
    <div></div>
    <div></div>
</div>


 <!-- Sidebar Menu -->
<div class="menu" id="menu">
    <!-- Logo at the top of the sidebar -->
    <div class="logo">
        <img src="logo.jpg" alt="Logo" class="logo-image">
    </div>


    <!-- Navigation links -->
    <a href="#" onclick="showSection('home')">Home</a>
    <a href="#" onclick="showSection('book')">Book</a>
    <a href="#" onclick="showSection('booked')">Booked</a>
    <a href="#" onclick="showSection('messages')">Messages</a>
    <a href="#" onclick="showSection('ratings')">Ratings</a>
    
 <!-- Theme Switch inside the sidebar -->
 <div class="theme-switch">
    <input type="checkbox" id="themeToggle" onclick="toggleTheme()">
    <label for="themeToggle">
        <span class="slider"></span> Light/Dark Mode
    </label>
</div>

    <!-- Log Out button -->
    <button class="logout" onclick="logout()">Log Out</button>
</div>



    <!-- Main Content -->
    <div class="content">
        <div id="home" class="section active">
            <h1>Welcome to the Staff Panel</h1>
            <p class="welcome-text">Hello Staff! This is your central dashboard where you can manage bookings, view messages, and check ratings. Use the menu on the left to navigate through different sections.</p>
        </div>

        <div id="book" class="section">
            <h2>Book a Room</h2>
            <div class="form-container">
                <form id="bookingForm">
                    <label for="checkInDate">Check-in Date:</label>
                    <input type="date" id="checkInDate" name="checkInDate" required>
                    
                    <label for="checkInTime">Check-in Time:</label>
                    <input type="time" id="checkInTime" name="checkInTime" required>
                    
                    <label for="checkOutDate">Check-out Date:</label>
                    <input type="date" id="checkOutDate" name="checkOutDate" required>
                    
                    <label for="numberOfGuests">Number of Guests:</label>
                    <input type="number" id="numberOfGuests" name="numberOfGuests" min="1" required>
                    
                    <button type="submit">Book Now</button>
                </form>
            </div>
        </div>

        <div id="booked" class="section">
            <h2>Bookings</h2>
            <table id="bookingsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Guests</th>
                        <th>Email</th>
                        <th>Approval Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['check_in']; ?></td>
                            <td><?php echo $row['check_out']; ?></td>
                            <td><?php echo $row['guests']; ?></td>
                            <td><?php echo $row['status'] == 'approved' ? "Approved" : "Pending"; ?></td>
                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <a href="?approve=1&id=<?php echo $row['id']; ?>">Approve</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="messages" class="section">
            <h2>Messages</h2>
            <table id="messagesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="ratings" class="section">
            <h2>Ratings</h2>
            <table id="ratingsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>

           // Fetch and display bookings
           fetch('fetch_booking.php')
    .then(response => response.json())
    .then(bookings => {
        const bookingsTable = document.getElementById('bookingsTable').getElementsByTagName('tbody')[0];
        bookings.forEach(booking => {
            const row = bookingsTable.insertRow();
            row.insertCell(0).textContent = booking.id;
            row.insertCell(1).textContent = booking.check_in;
            row.insertCell(2).textContent = booking.check_out;
            row.insertCell(3).textContent = booking.guests;
            row.insertCell(4).textContent = booking.email;

            // Approval status
            const approvalCell = row.insertCell(5);
            approvalCell.textContent = booking.approved ? "Approved" : "Pending";

            // Approve button
            const actionCell = row.insertCell(6);
            if (!booking.approved) { // Show approve button only if not approved
                const approveButton = document.createElement('button');
                approveButton.textContent = "Approve";
                approveButton.onclick = () => approveBooking(booking.id);
                actionCell.appendChild(approveButton);
            }
        });
    })
    .catch(error => console.error('Error fetching bookings:', error));

    function approveBooking(bookingId) {
    fetch(`approve_booking.php?id=${bookingId}`, { method: 'GET' })
        .then(response => {
            if (response.ok) {
                alert('Booking approved successfully!');
                location.reload(); // Reload the page to reflect the updated approval status
            } else {
                alert('Error approving booking.');
            }
        })
        .catch(error => console.error('Error:', error));
}

        // Fetch and display messages
        fetch('fetch_messages.php')
            .then(response => response.json())
            .then(messages => {
                const messagesTable = document.getElementById('messagesTable').getElementsByTagName('tbody')[0];
                messages.forEach(message => {
                    const row = messagesTable.insertRow();
                    row.insertCell(0).textContent = message.id;
                    row.insertCell(1).textContent = message.name;
                    row.insertCell(2).textContent = message.email;
                    row.insertCell(3).textContent = message.message;
                });
            })
            .catch(error => console.error('Error fetching messages:', error));


        function toggleMenu() {
            document.getElementById('menu').classList.toggle('active');
        }

        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }

        function logout() {
            window.location.href = 'login.html'; // Update with your logout URL
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>

