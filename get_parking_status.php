<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // ganti dengan password MySQL Anda
$dbname = 'if0_37749226_project';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil status slot parkir
$sql = "SELECT * FROM parking_slots";
$result = $conn->query($sql);

$parkingSlots = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $parkingSlots[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($parkingSlots);

$conn->close();
?>
