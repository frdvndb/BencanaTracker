<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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
        font-size: 1.2rem;
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

    h6 {
        font-weight: bold;
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

    .leaflet-popup-content {
        text-transform: none;
    }

    #attribution {
        position: absolute;
        bottom: 10px;
        left: 10px;
        font-size: 6px;
        color: #666;
    }

    #getLocationButton {
        position: absolute;
        bottom: 30px;
        left: 260px;
        z-index: 1000;
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
                            href="<?= base_url('map'); ?>">LAPORKAN<br> BENCANA</a>
                    </li>
                    <div class="main-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/'); ?>"><i
                                    class="bi bi-house-fill"></i> Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('notifikasi'); ?>"><i
                                    class="bi bi-bell-fill"></i> Notifikasi</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('pencarianrelawan'); ?>"><i
                                    class="bi bi-people-fill"></i> Cari Relawan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('histori_laporan'); ?>"><i
                                    class="bi bi-clock-history"></i> Histori Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('donasi'); ?>"><i
                        class="bi bi-cash-stack"></i> Support Us</a></li>
                        <?php if (!$username == null) { ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('logout'); ?>"><i
                                    class="bi bi-box-arrow-right"></i> Logout</a></li>
                        <?php } else {?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('register'); ?>"><i
                                    class="bi bi-person-plus-fill"></i> Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('login'); ?>"><i
                                    class="bi bi-box-arrow-in-right"></i> Login</a></li>
                        <?php } ?>
                    </div>
                    <div class="bottom-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>"><i
                                    class="bi bi-person"></i> <?= $username ?></a></li>
                    </div>
                </ul>
            </div>
            <!-- Bagian konten -->
            <div class="col-md-10 content">
                <div id="gmapBlock"></div>
                <button id="getLocationButton" class="btn btn-primary">
                    <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                </button>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    var map = L.map('gmapBlock').setView([-3.89, 115.28], 4);
                    var popupOffset = L.point(0, -20);
                    // set map tiles source
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '<div id="attribution">Icons made by <a href="https://www.flaticon.com/authors/pixel-perfect" title="Pixel perfect">Pixel perfect</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div> Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                        maxZoom: 18
                    }).addTo(map);

                    // Memuat plugin Leaflet Control Geocoder
                    L.Control.geocoder({
                        defaultMarkGeocode: false,
                        collapsed: false, // Menampilkan panel pencarian secara terbuka
                        placeholder: "Cari lokasi...", // Menyesuaikan placeholder dengan teks yang diinginkan
                        errorMessage: "Lokasi tidak ditemukan.", // Menyesuaikan pesan error dengan teks yang diinginkan
                        showResultIcons: true, // Menampilkan ikon pada hasil pencarian
                        geocoder: L.Control.Geocoder.nominatim(), // Menggunakan geocoder dari Nominatim
                        // Mengatur aksi setelah pencarian berhasil
                        geocoder: new L.Control.Geocoder.nominatim({
                            geocodingQueryParams: { // Menyesuaikan parameter pencarian
                                countrycodes: 'ID', // Mengatur pencarian hanya di Indonesia
                                limit: 5 // Mengatur jumlah hasil pencarian yang ditampilkan
                            }
                        }),
                        // Aksi setelah pencarian berhasil
                        collapsed: false
                    }).on('markgeocode', function (e) {
                        var location = e.geocode.center;
                        var marker = L.marker(location).addTo(map);
                        var address = e.geocode.name;

                        // Menambahkan popup pada marker dengan informasi lokasi
                        marker.bindPopup(address).openPopup();
                        map.flyTo(e.geocode.center, 15); // Menggerakkan peta ke lokasi yang ditemukan
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
                        if (locationMarkers[i][0] === 'Banjir') {
                            customIcon = L.icon({
                                iconUrl: "<?= base_url('../assets/img/marker_banjir.png') ?>",
                                iconSize: [32, 32],
                                iconAnchor: [15, 30],
                            });
                        } else if (locationMarkers[i][0] === 'Gempa Bumi') {
                            customIcon = L.icon({
                                iconUrl: "<?= base_url('../assets/img/marker_gempa.png') ?>",
                                iconSize: [32, 32],
                                iconAnchor: [15, 30],
                            });
                        } else if (locationMarkers[i][0] === 'Kecelakaan') {
                            customIcon = L.icon({
                                iconUrl: "<?= base_url('../assets/img/marker_kecelakaan.png') ?>",
                                iconSize: [32, 32],
                                iconAnchor: [15, 30],
                            });
                        } else if (locationMarkers[i][0] === 'Tanah Longsor') {
                            customIcon = L.icon({
                                iconUrl: "<?= base_url('../assets/img/marker_longsor.png') ?>",
                                iconSize: [32, 32],
                                iconAnchor: [15, 30],
                            });
                        } else {
                            customIcon = L.icon({
                                iconUrl: "<?= base_url('../assets/img/placeholder.png') ?>",
                                iconSize: [32, 32],
                                iconAnchor: [15, 30],
                            });
                        }

                        var marker = L.marker([locationMarkers[i][1], locationMarkers[i][2]], { icon: customIcon })
                            .addTo(map)
                            .bindPopup(locInfo[i][0] + '<br><a href="<?= base_url("laporan/") ?>' + locationMarkers[i][3] + '" class="btn btn-primary" style="color: #fff;">Lihat detail laporan</a>', { offset: popupOffset });
                    } 

                    var getLocationButton = document.getElementById('getLocationButton');
                    getLocationButton.addEventListener('click', getUserLocation);

                    // Get user's current location
                    function getUserLocation() {
                        if ("geolocation" in navigator) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;

                                L.marker([latitude, longitude]).bindPopup('Lokasi Anda').addTo(map);
                                // animate zoom to user location
                                map.flyTo([latitude, longitude], 13, {
                                    animate: true,
                                    duration: 3 // durasi animasi dalam detik
                                });
                            });
                        } else {
                            console.log('Geolocation is not supported by this browser.');
                        }
                    }

                    function getLatestReports() {  
                            // Kirim permintaan ke server untuk mendapatkan data laporan terbaru
                            $.ajax({
                                url: '<?= base_url() ?>' + '/latest/' + maxId.id,
                                method: 'GET',
                                dataType: 'json',
                                success: function (response) {

                                    var dataMarker = JSON.parse(response.locationMarkers);
                                    var dataLocInfo = JSON.parse(response.locInfo);
                                    maxId = JSON.parse(response.maxId);

                                    for (var i = 0; i < dataMarker.length; i++) {
                                        if (dataMarker[i][0] === 'Banjir') {
                                            customIcon = L.icon({
                                                iconUrl: "<?= base_url('../assets/img/marker_banjir.png') ?>",
                                                iconSize: [32, 32],
                                                iconAnchor: [15, 30],
                                            });
                                        } else if (dataMarker[i][0] === 'Gempa Bumi') {
                                            customIcon = L.icon({
                                                iconUrl: "<?= base_url('../assets/img/marker_gempa.png') ?>",
                                                iconSize: [32, 32],
                                                iconAnchor: [15, 30],
                                            });
                                        } else if (dataMarker[i][0] === 'Kecelakaan') {
                                            customIcon = L.icon({
                                                iconUrl: "<?= base_url('../assets/img/marker_kecelakaan.png') ?>",
                                                iconSize: [32, 32],
                                                iconAnchor: [15, 30],
                                            });
                                        } else if (dataMarker[i][0] === 'Tanah Longsor') {
                                            customIcon = L.icon({
                                                iconUrl: "<?= base_url('../assets/img/marker_longsor.png') ?>",
                                                iconSize: [32, 32],
                                                iconAnchor: [15, 30],
                                            });
                                        } else {
                                            customIcon = L.icon({
                                                iconUrl: "<?= base_url('../assets/img/placeholder.png') ?>",
                                                iconSize: [32, 32],
                                                iconAnchor: [15, 30],
                                            });
                                        }
                                        var marker = L.marker([dataMarker[i][1], dataMarker[i][2]], { icon: customIcon })
                                            .addTo(map)
                                            .bindPopup(dataLocInfo[i][0] + '<a href="<?= base_url("laporan/") ?>' + dataMarker[i][3] + '">Detail Bencana</a>', { offset: popupOffset });
                                    }     

                                },
                                error: function (xhr, status, error) {
                                    log(xhr.responseText);
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
<!-- Include library SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Cek flash data 'success' -->
<?php if (session()->getFlashdata('success')): ?>
    <script>
        // Tampilkan pesan popup menggunakan SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>'
        });
    </script>
<?php endif; ?>
</html>