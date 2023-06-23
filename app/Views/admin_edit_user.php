<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
        integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>

    <style>
    .container-fluid {
        max-width: 100%;
    }

    #gmapBlock {
        width: 80%;
        height: 80%;
        margin-left: 40px;
        margin-top: 30px;
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
        height: 100vh;
        padding: 20px;
        background-color: #E5E5E5;
        background-size: cover;
        background-position: center;
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-weight: 500;
        overflow: auto;
    }

    h1 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 700;
        line-height: 1.2;
        text-align: center;
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

    table {
        background-color: #1546BA;
        border-radius: 10px;
        margin-top: 10px;
        padding-bottom: 5px;
    }

    .table-wrapper {
        overflow-x: auto;
        max-height: 100%;
        width: 100%;
    }

    table th,
    td {
        color: white;
    }

    .into-content {
        display: flex;
        justify-content: space-between;
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
                    <?php if ($isAdmin == null) { ?>
                    <li class="nav-item">
                        <a class="btn btn-primary laporButton" style="color: #FF5757;"
                            href="<?= base_url('map'); ?>">LAPORKAN<br> BENCANA</a>
                    </li>
                    <?php } ?>
                    <?php if (!$isAdmin == null && $isAdmin == 1) { ?>
                    <li class="nav-item">
                        <a class="btn btn-primary laporButton" style="color: #FF5757;" href="<?= base_url('/'); ?>">Hi,
                            Admin</a>
                    </li>
                    <?php } ?>
                    <div class="main-sidebar">
                        <?php if (!$isAdmin == null && $isAdmin == 1) { ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_lb'); ?>"><i
                                    class="bi bi-list-check"></i> Daftar Peristiwa</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_user'); ?>"><i
                                    class="bi bi-people"></i> Daftar Pengguna</a></li>
                        <?php } else {?>
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
                                    class="bi bi-cash-stack"></i> Donasi</a></li>
                        <?php } ?>
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
                <h1>Daftar Pengguna</h1>
                <?php if (validation_list_errors()) : ?>
                <div class="alert alert-danger" style="width: fit-content;">
                    <p><?= validation_list_errors(); ?></p>
                </div>
                <?php endif; ?>

                <!-- Formulir edit data. -->
                <div class="into-content">
                    <div class="col-6">
                        <form action="<?= base_url('edit_user/'.$data['id']) ?>" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?= $data['username'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="<?= $data['email'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="garis_lintang" class="form-label">Garis Lintang</label>
                                <input type="text" class="form-control" id="garis_lintang" name="garis_lintang"
                                    value="<?= $data['garis_lintang'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="garis_bujur" class="form-label">Garis Bujur</label>
                                <input type="text" class="form-control" id="garis_bujur" name="garis_bujur"
                                    value="<?= $data['garis_bujur'] ?>">
                            </div>
                            <button type="submit" class="w-100 btn btn-primary">Edit</button>
                        </form>

                    </div>
                    <div class="col-md-6">
                            <div id="gmapBlock"></div>
                        </div>
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

            var latitudeInput = document.getElementById('garis_lintang');
            var longitudeInput = document.getElementById('garis_bujur');

            latitudeInput.value = clickedLocation.lat;
            longitudeInput.value = clickedLocation.lng;
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
        </script>
</body>

</html>