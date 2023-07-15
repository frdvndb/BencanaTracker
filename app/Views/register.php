<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet"
        type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
        integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <style>
    body {
        background-color: #1546BA;
        background-repeat: no-repeat;
        background-size: cover;
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        display: grid;
        place-items: center;
        min-height: 100vh;
    }

    #gmapBlock {
        width: 100%;
        height: 100%;
    }

    .form-floating {
        margin-top: 10px;
    }

    .h2w {
        color: white;
    }

    .h2o {
        color: #FF5757;
    }

    #getLocationButton {
        position: absolute;
        bottom: 70px;
        right: 560px;
        z-index: 1000;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><span class="h2w">Bencana</span><span class="h2o">Tracker</span></h2>
                <h2 class="h2w">Register Akun</h2>
                <?= validation_list_errors() ?>
                <form action="<?= base_url('register') ?>" method="post">
                    <div class="form-floating">
                        <input name="email" type="email" class="form-control" id="floatingInput"
                            placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input name="password" type="password" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating">
                        <input name="nomor_hp" type="nomor_hp" class="form-control" id="floatingInput"
                            placeholder="Nomor HP">
                        <label for="floatingInput">Nomor HP</label>
                    </div>
                    <div class="form-floating">
                        <input name="username" type="username" class="form-control" id="floatingInput"
                            placeholder="Username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating">
                        <input name="latitude" type="text" class="form-control" id="latitudeInput"
                            placeholder="Latitude">
                        <label for="latitudeInput">Garis Lintang</label>
                    </div>
                    <div class="form-floating">
                        <input name="longitude" type="text" class="form-control" id="longitudeInput"
                            placeholder="Longitude">
                        <label for="longitudeInput">Garis Bujur</label>
                    </div>
                    <button type="submit" class="w-100 mt-2 btn btn-success">Buat</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="gmapBlock"></div>
                <button id="getLocationButton" class="btn btn-primary">
                    <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                </button>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('gmapBlock').setView([-3.89, 115.28], 4);
        var marker;

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
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

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(location).addTo(map);
            var address = e.geocode.name;

            var latitudeInput = document.getElementById('latitudeInput');
            var longitudeInput = document.getElementById('longitudeInput');
            latitudeInput.value = location.lat;
            longitudeInput.value = location.lng;

            // Menambahkan popup pada marker dengan informasi lokasi
            marker.bindPopup(address).openPopup();
            map.flyTo(e.geocode.center, 15); // Menggerakkan peta ke lokasi yang ditemukan
        }).addTo(map);


        map.on('click', function(event) {
            var clickedLocation = event.latlng;

            // Hapus penanda yang ada
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(clickedLocation).addTo(map);

            var latitudeInput = document.getElementById('latitudeInput');
            var longitudeInput = document.getElementById('longitudeInput');

            latitudeInput.value = clickedLocation.lat;
            longitudeInput.value = clickedLocation.lng;
        });

        var getLocationButton = document.getElementById('getLocationButton');
        getLocationButton.addEventListener('click', getUserLocation);

        // Mendapatkan lokasi user saat ini
        function getUserLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    var latitudeInput = document.getElementById('latitudeInput');
                    var longitudeInput = document.getElementById('longitudeInput');

                    latitudeInput.value = latitude;
                    longitudeInput.value = longitude;


                    marker = L.marker([latitude, longitude]).addTo(map);
                    // animasikan zoom ke lokasi user
                    map.flyTo([latitude, longitude], 13, {
                        animate: true,
                        duration: 3 // durasi animasi dalam detik
                    });
                });
            } else {
                console.log('Geolocation is not supported by this browser.');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>