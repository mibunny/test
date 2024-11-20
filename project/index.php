<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Management - Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        nav {
            background-color: rgba(51, 51, 51, 1); /* Warna gelap untuk navigasi */
            padding: 1px;
            text-align: right;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            margin-top: 15px;
            color: white; /* Warna gelap untuk kontras */
        }
        p {
            text-align: center;
            color: white; /* Warna lebih terang untuk teks */
        }
        .container {
            text-align: center;
            margin-top: 30px;
        }
        .map-container {
            width: 65%;
            height: 450px; /* Tinggi untuk iframe */
            margin: 0 auto; /* Pusatkan kontainer peta */
            border-radius: 10px; /* Sudut melengkung */
            overflow: hidden; /* Menghindari overflow */
        }
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none; /* Hapus border dari iframe */
        }
        .cta-button {
            display: inline-block;
            background-color: rgba(51, 51, 51, 1);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            margin-top: 5px;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: steelblue; /* Efek hover */
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
    <h1>Selamat Datang di Sistem Manajemen Parkir</h1>
    <p>Temukan slot parkir dengan mudah!</p>

    <div class="container">
        <div class="map-container">
            <iframe src="live-map1.php" title="Live Parking Map"></iframe> <!-- Ganti dengan URL live map Anda -->
        </div>
        <br>
        <a href="login.php" class="cta-button">Mulai Sekarang</a>
    </div>
</body>
</html>
