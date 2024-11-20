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

// Mengambil data slot yang tersedia
$query = "SELECT slot_name FROM parking_slots WHERE status = 'available'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Parking Slot</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('images/parkir.jpg'); /* Ganti dengan gambar latar yang menarik */
            background-size: cover;
            background-position: center;
            color: white;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(51, 51, 51); /* Semi-transparent untuk efek modern */
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

        .booking-container {
            margin-top: 70px; /* Memberikan margin atas untuk navbar */
            padding: 40px;
            max-width: 600px;
            margin: 165px auto;
            background-color: rgba(0, 0, 0, 0.7); /* Latar belakang transparan untuk konten */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            color: #ffcc00; /* Warna kuning untuk menarik perhatian */
        }

        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        select {
            background-color: white;
            color: #333;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Hijau untuk tombol */
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Warna lebih gelap saat hover */
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: #ffcc00; /* Warna kuning untuk pesan sukses */
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
        <li><a href="my_bookings.php">My Bookings</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<div class="booking-container">
    <h1>Book a Parking Slot</h1>
    <form action="booking_process.php" method="POST">
        <label for="slot">Select a Parking Slot:</label>
        <select name="slot_name" id="slot" required>
            <option value="" disabled selected>Select a slot</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['slot_name']) . '">' . htmlspecialchars($row['slot_name']) . '</option>';
                }
            } else {
                echo '<option value="" disabled>No available slots</option>';
            }
            ?>
        </select>
        <input type="submit" value="Book Slot">
    </form>

    <?php
    if (isset($_SESSION['booking_message'])) {
        echo '<p class="message">' . htmlspecialchars($_SESSION['booking_message']) . '</p>';
        unset($_SESSION['booking_message']); // Hapus pesan setelah ditampilkan
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
