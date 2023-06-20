<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
    <style>
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

    h1 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 700;
        line-height: 1.2;
        font-size: calc(1.725rem + 5.7vw);
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

    .h2o {
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
    </style>
</head>

<body>
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
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('pencarianrelawan'); ?>">Pencarian Relawan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('histori_laporan'); ?>">Histori Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('donasi'); ?>">Donasi</a></li>
                        <?php if (!$username == null) { ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('logout'); ?>">Logout</a></li>
                        <?php } else {?>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('register'); ?>">Register</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= base_url('login'); ?>">Login</a></li>
                        <?php } ?>
                    </div>
                    <div class="bottom-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>"><?= $username ?></a></li>
                    </div>
                </ul>
            </div>
            <!-- Bagian konten -->
            <div class="col-md-10 content">
                <div id="gmapBlock"></div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    var map = L.map('gmapBlock').setView([-3.89, 115.28], 4);

                    // set map tiles source
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                        maxZoom: 18
                    }).addTo(map);

                    map.on('click', function(event) {
                    var clickedLocation = event.latlng;
                    var marker = L.marker(clickedLocation).addTo(map);

                    var locationName = "";
                    var latitude = clickedLocation.lat;
                    var longitude = clickedLocation.lng;

                    if (latitude !== null && latitude !== "") {
                        localStorage.setItem('clickedLocation', JSON.stringify({
                            latitude: latitude,
                            longitude: longitude,
                            locationName: locationName
                        }));
                        window.location.href = '<?= base_url("buat_laporan") ?>';
                    } else {
                        marker.remove();
                    }
                });


                    // retrieve marker data from the database
                    var locationMarkers = JSON.parse(`<?php echo ($locationMarkers); ?>`);
                    var locInfo = JSON.parse(`<?php echo ($locInfo); ?>`);
                    var maxId = JSON.parse(`<?php echo ($maxId); ?>`);
                    // loop through the marker data and add markers to the map
                    for (var i = 0; i < locationMarkers.length; i++) {
                        var marker = L.marker([locationMarkers[i][1], locationMarkers[i][2]])
                            .addTo(map)
                            .bindPopup(locInfo[i][0] + '<a href="<?= base_url("laporan/") ?>' + locationMarkers[i][3] + '">Detail Bencana</a>');
                    }     
                    
                    function getLatestReports() {  
                            // Kirim permintaan ke server untuk mendapatkan data laporan terbaru
                            $.ajax({
                                url: '<?= base_url() ?>' + '/latest/' + maxId.id,
                                method: 'GET',
                                dataType: 'json',
                                success: function (response) {
                                    // alert('1');

                                    var dataMarker = JSON.parse(response.locationMarkers);
                                    var dataLocInfo = JSON.parse(response.locInfo);
                                    maxId = JSON.parse(response.maxId);

                                    for (var i = 0; i < dataMarker.length; i++) {
                                        var marker = L.marker([dataMarker[i][1], dataMarker[i][2]])
                                            .addTo(map)
                                            .bindPopup(dataLocInfo[i][0] + '<a href="<?= base_url("laporan/") ?>' + dataMarker[i][3] + '">Detail Bencana</a>');
                                    }     

                                },
                                error: function (xhr, status, error) {
                                    alert(xhr.responseText);
                                }
                            });
                        }

                        getLatestReports(); // Panggil fungsi untuk pertama kali

                        setInterval(getLatestReports, 5000);

                </script>
            </div>
        </div>
    </div>
</body>

</html>