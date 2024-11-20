<?php
session_start();

// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'if0_37749226_project'; // Nama database
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Cek apakah username ditemukan
    if ($stmt->num_rows > 0) {
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username; // Simpan sesi pengguna
            header("Location: home.php"); // Arahkan ke halaman utama
            exit();
        }
    }

    // Jika login gagal, set pesan error dalam sesi
    $_SESSION['error'] = "Username atau Password Anda Salah";
    header("Location: login.php"); // Arahkan kembali ke halaman login
    exit();
}

$stmt->close();
$conn->close();
?>
