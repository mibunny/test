<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Parking Map</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #map {
            width: 1000px;
            height: 500px;
            margin-top: 25px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .row {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            margin-bottom: 55px;
        }

        .parking-spot {
            width: 100px;
            height: 160px;
            background-color: #e0e0e0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: 600;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
            margin: 0 30px;
            position: relative; /* Untuk mengatur posisi tombol */
        }

        .available {
            background-color: #4CAF50;
        }

        .occupied {
            background-color: #F44336;
        }

        .booked {
    background-color: goldenrod; /* Warna untuk slot yang dibooking */
}

        .entrance, .exit, .lt2, .lt1 {
            position: absolute;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .entrance {
            top: 20px;
            left: 70px;
        }

        .exit {
            top: 20px;
            right: 70px;
        }

        .lt1 {
            bottom: 20px;
            right: 70px;
        }

        .lt2 {
            bottom: 20px;
            left: 70px;
        }

        .update-button {
            position: absolute;
            bottom: 10px; /* Menempatkan tombol di bawah slot */
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 10px;
            font-size: 12px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        
    </style>
    <script>
        function fetchParkingStatus() {
            fetch('get_parking_status.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(slot => {
                        const parkingSpot = document.getElementById(slot.slot_name);
                        if (parkingSpot) {
                            parkingSpot.className = 'parking-spot ' + slot.status;
                            parkingSpot.textContent = slot.slot_name; // Menampilkan nama slot
                        }
                    });
                })
                .catch(error => console.error('Error fetching parking status:', error));
        }

        function updateParkingStatus(slotName, currentStatus) {
            const formData = new FormData();
            formData.append('slot_name', slotName);
            formData.append('current_status', currentStatus);

            fetch('update_parking_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    fetchParkingStatus(); // Memperbarui status setelah perubahan
                } else {
                    console.error('Error updating parking status:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        setInterval(fetchParkingStatus, 2000); // Memperbarui setiap 5 detik
    </script>
</head>
<body>

    <!-- Include the navigation bar -->
    <?php include('nav.php'); ?>

    <!-- Map Container -->
    <div id="map">
        <div class="entrance">MASUK</div>

        <div class="row">
            <div id="P1" class="parking-spot available">P1
                <button class="update-button" onclick="updateParkingStatus('P1', 'available')">Update</button>
            </div>
            <div id="P2" class="parking-spot occupied">P2
                <button class="update-button" onclick="updateParkingStatus('P2', 'occupied')">Update</button>
            </div>
            <div id="P3" class="parking-spot available">P3
                <button class="update-button" onclick="updateParkingStatus('P3', 'available')">Update</button>
            </div>
        </div>

        <div class="row">
            <div id="P4" class="parking-spot occupied">P4
                <button class="update-button" onclick="updateParkingStatus('P4', 'occupied')">Update</button>
            </div>
            <div id="P5" class="parking-spot available">P5
                <button class="update-button" onclick="updateParkingStatus('P5', 'available')">Update</button>
            </div>
            <div id="P6" class="parking-spot occupied">P6
                <button class="update-button" onclick="updateParkingStatus('P6', 'occupied')">Update</button>
            </div>
        </div>

        <div class="exit">KELUAR</div>

        <div class="lt1">LANTAI 1</div>
        <div class="lt2">LANTAI 2</div>
    </div>

    <script>
        // Memanggil fungsi untuk memperbarui status parkir saat halaman dimuat
        fetchParkingStatus();
    </script>

</body>
</html>
