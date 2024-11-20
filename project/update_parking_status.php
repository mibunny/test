<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // Sesuaikan dengan password MySQL Anda
$dbname = 'if0_37749226_project';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memeriksa apakah parameter slot_name dan current_status ada
if (isset($_GET['slot_name']) && isset($_GET['current_status'])) {
    $slot_name = $_GET['slot_name'];
    $current_status = $_GET['current_status'];

    // Tentukan status baru
    $new_status = $current_status;

    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("UPDATE parking_slots SET status = ? WHERE slot_name = ?");
    $stmt->bind_param("ss", $new_status, $slot_name);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'new_status' => $new_status]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    // Jika parameter tidak lengkap
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
}

$conn->close();
?>
