<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // Sesuaikan dengan password MySQL Anda
$dbname = 'if0_37749226_project';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(51, 51, 51, 1);
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar .logo a {
            color: white;
            font-size: 24px;
            text-decoration: none;
        }

        .main-content {
            margin-top: 100px; /* Memberikan margin atas untuk navbar */
            padding: 20px;
            max-width: 800px;
            margin: 185px auto;
            background-color: black;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: black;
        }

        table tr:hover {
            background-color: brown;
        }

        .cancel-button {
            background-color: #ff4c4c;
            color: black;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #e63939;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="index.php">Parking System</a>
    </div>
    <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="live-map.php">Live Map</a></li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Your Bookings</h1>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        $stmt = $conn->prepare("SELECT id, slot_name, booking_time FROM bookings WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Slot Name</th><th>Booking Time</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['slot_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['booking_time']) . '</td>';
                echo '<td><a href="cancel_booking.php?id=' . htmlspecialchars($row['id']) . '" class="cancel-button">Cancel</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "<p style='text-align: center;'>Anda belum melakukan booking.</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='text-align: center;'>Anda harus login untuk melihat booking Anda.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
