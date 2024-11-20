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

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data dari form
$username = $_SESSION['username'];
$slot_name = $_POST['slot_name'];

// Memeriksa apakah slot sudah dibooking
$stmt = $conn->prepare("SELECT status FROM parking_slots WHERE slot_name = ?");
$stmt->bind_param("s", $slot_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['status'] == 'available') {
        // Simpan booking ke database
        $stmt = $conn->prepare("INSERT INTO bookings (username, slot_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $slot_name);
        if ($stmt->execute()) {
            // Update status slot parkir menjadi 'booked'
            $stmt = $conn->prepare("UPDATE parking_slots SET status = 'booked' WHERE slot_name = ?");
            $stmt->bind_param("s", $slot_name);
            $stmt->execute();

            echo "Booking berhasil untuk slot: " . htmlspecialchars($slot_name);
            header("Location: my_bookings.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Slot parkir sudah dibooking.";
    }
} else {
    echo "Slot tidak ditemukan.";
}

$stmt->close();
$conn->close();
?>
