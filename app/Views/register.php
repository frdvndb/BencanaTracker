<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
            </div>
        </div>
    </div>

    <script>
    var map = L.map('gmapBlock').setView([-3.89, 115.28], 4);
    var marker;

    // set map tiles source
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);

    map.on('click', function(event) {
        var clickedLocation = event.latlng;

        // Remove existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker(clickedLocation).addTo(map);

        var latitudeInput = document.getElementById('latitudeInput');
        var longitudeInput = document.getElementById('longitudeInput');

        latitudeInput.value = clickedLocation.lat;
        longitudeInput.value = clickedLocation.lng;
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>