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

// Memeriksa apakah ID booking diberikan
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Mengambil data booking untuk mendapatkan nama slot
    $stmt = $conn->prepare("SELECT slot_name FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $slot_name = $row['slot_name'];

        // Menghapus booking dari database
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $booking_id);

        if ($stmt->execute()) {
            // Mengupdate status slot parkir kembali menjadi 'available'
            $stmt = $conn->prepare("UPDATE parking_slots SET status = 'available' WHERE slot_name = ?");
            $stmt->bind_param("s", $slot_name);
            $stmt->execute();

            echo "Booking untuk slot: " . htmlspecialchars($slot_name) . " berhasil dibatalkan.";
            header("Location: my_bookings.php");
            exit();
        } else {
            echo "Error saat membatalkan booking: " . $stmt->error;
        }
    } else {
        echo "Booking tidak ditemukan.";
    }

    $stmt->close();
} else {
    echo "ID booking tidak diberikan.";
}

$conn->close();
?>
