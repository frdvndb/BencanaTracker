<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Codeigniter 4 Show Multiple Markers on Google Map Example</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        margin: auto;
        width: 30%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        background-color: #1546BA;
    }

    .container-fluid {
        max-width: 100%;
    }

    #gmapBlock {
        width: 100%;
        height: 100%;
    }

    .sidebar {
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #1546BA;
        padding: 20px;
        font-size: 1.5rem;
        height: 100vh;
        position: relative;

    }

    .sidebar a {
        color: white;
    }

    .sidebar a:hover {
        color: #00B4D8;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        height: 100vh;
        padding: 20px;
        background-color: #E5E5E5;
        background-size: cover;
        background-position: center;
        text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        text-transform: uppercase;
        font-weight: 500;
        font-size: 1.5rem;
        color: #343a40;
    }

    .background-input {
        background-color: #1546BA;
        color: white;
    }

    button {
        background-color: #1546BA;
        color: white;
        border-color: white;
    }

    h1 {
        color: white;
    }

    .text-primary {
        --bs-primary-rgb: 189, 93, 56;
        --bs-text-opacity: 1;
        color: rgba(var(--bs-primary-rgb), var(--bs-text-opacity)) !important;
    }

    .img-profile {
        border: 10px solid white;
        border-radius: 50%;
        width: 150px;
        height: 150px;
    }

    .h2w {
        color: white;
    }

    .h2o,
    label {
        color: #FF5757;
    }

    .laporButton {
        background-color: white;
        color: #FF5757;
        font-weight: bold;
        width: 100%;
        margin-top: 40px;
    }

    .bottom-sidebar {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        text-align: center;
        color: #FF5757;
    }

    .bottom-sidebar li {
        border: 1px solid white;
        width: 80%;
        margin: 0 auto;
        background-color: #FF5757;

    }

    .background-proses {
        background-color: #00cc99;
    }

    body{
        background-color: #E5E5E5;
    }

    </style>
</head>

<body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var clickedLocation = JSON.parse(localStorage.getItem('clickedLocation'));

        // Pre-fill the input fields with the clicked location data
        document.getElementById('latitude').value = clickedLocation.latitude;
        document.getElementById('longitude').value = clickedLocation.longitude;
        document.getElementById('locationName').value = clickedLocation.locationName;
    });
    </script>
    <div class="container-fluid">
        <div class="row">
            <!-- Bagian sidebar -->
            <div class="col-md-2 sidebar">
                <h2><span class="h2w">Bencana</span><span class="h2o">Tracker</span></h2>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="btn btn-primary laporButton" style="color: #FF5757;"
                            href="<?= base_url('buat_laporan'); ?>">LAPORKAN<br> BENCANA</a>
                    </li>
                    <div class="main-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('beranda'); ?>">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('notifikasi'); ?>">Notifikasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('pencarianrelawan'); ?>">Pencarian
                                Relawan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('histori_laporan'); ?>">Histori Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('donasi'); ?>">Donasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('login'); ?>">Logout</a></li>
                    </div>
                    <div class="bottom-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>"><?= $username ?></a></li>
                    </div>
                </ul>
            </div>

            <div class="col-md-10 card">
                <center>
                    <h1> Buat Laporan </h1>
                </center>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <form action="buat_laporan" method="POST">
                    <div class="form-group">
                        <label for="location_name">Bencana yang terjadi:</label>
                        <select id="location_name" name="location_name" onchange="checkCustomLocation(this)"
                            class="form-control">
                            <option value="pilih" selected disabled>Pilih Bencana</option>
                            <option value="bencana1">Banjir</option>
                            <option value="bencana2">Gempa Bumi</option>
                            <option value="bencana3">Kecelakaan</option>
                            <option value="bencana4">Tanah Longsor</option>
                            <option value="custom">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group" style="padding-top: 5px;">
                        <input type="text" id="custom_location" name="custom_location" style="display: none;"
                            placeholder="Masukkan Bencana Yang Terjadi" class="form-control">
                    </div><br>
                    <div class="form-group">
                        <label for="nama_lokasi">Lokasi:</label>
                        <input type="text" id="nama_lokasi" name="nama_lokasi" class="form-control">
                    </div><br>
                    <div class="form-group">
                        <label for="latitude">Garis Lintang:</label>
                        <input type="text" id="latitude" name="latitude" class="form-control">
                    </div><br>
                    <div class="form-group">
                        <label for="longitude">Garis Bujur:</label>
                        <input type="text" id="longitude" name="longitude" class="form-control">
                    </div><br>
                    <div class="form-group">
                        <label for="info">Detail:</label>
                        <textarea id="info" name="info" rows="4" cols="40" class="form-control"></textarea>
                    </div><br>
                    <div class="form-group">
                        <label for="image">Upload Gambar:</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div><br>
                    <div class="text-center">
                        <input type="submit" value="Submit" class="btn btn-primary background-proses"
                            style="width: 100%; max-width: 100%;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
function checkCustomLocation(selectElement) {
    var customLocationInput = document.getElementById("custom_location");
    if (selectElement.value === "custom") {
        customLocationInput.style.display = "block";
        customLocationInput.required = true;
        customLocationInput.name = "location_name"; // Change the name attribute to "location_name"
    } else {
        customLocationInput.style.display = "none";
        customLocationInput.required = false;
        customLocationInput.name = "custom_location"; // Change the name attribute to "custom_location"
    }
}

document.getElementById("location_name").addEventListener("change", function() {
    var selectedOption = this.options[this.selectedIndex];
    var customLocationInput = document.getElementById("custom_location");
    if (selectedOption.value === "custom") {
        customLocationInput.value = ""; // Clear previous input
        customLocationInput.style.display = "block";
        customLocationInput.required = true;
        customLocationInput.name = "location_name"; // Change the name attribute to "location_name"
    } else {
        customLocationInput.style.display = "none";
        customLocationInput.required = false;
        customLocationInput.name = "custom_location"; // Change the name attribute to "custom_location"
    }
});
</script>

<script>
    $(document).ready(function() {
        $('.searchable-select').select2();
    });
</script>
