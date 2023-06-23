<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        height: 100vh;
        padding: 20px;
        background-color: #E5E5E5;
        background-size: cover;
        background-position: center;
        text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-weight: 500;
        color: #343a40;
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
                            href="<?= base_url('map'); ?>">LIHAT<br> PETA</a>
                    </li>
                    <div class="main-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('beranda'); ?>">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('notifikasi'); ?>">Notifikasi</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('pencarianrelawan'); ?>">Pencarian
                                Relawan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('histori_laporan'); ?>">Histori
                                Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('donasi'); ?>">Donasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_lb'); ?>">Daftar Laporan Bencana</a></li>    
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_user'); ?>">Daftar Pengguna</a></li>  
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
                <h1>Daftar Laporan Bencana</h1>
                <!-- Validasi data yang dimasukkan
        untuk menentukan apakah sudah sesuai 
        aturan atau tidak. -->
                <?php if (validation_list_errors()) : ?>
                <div class="alert alert-danger" style="width: fit-content;">
                    <p><?= validation_list_errors(); ?></p>
                </div>
                <?php endif; ?>

                <!-- Formulir edit data. -->
                <div class="col-3">
                    <form action="<?= base_url('edit_laporan_bencana/'.$data['id']) ?>" method="post">
                        <div class="mb-3">
                            <label for="peristiwa" class="form-label">Peristiwa</label>
                            <input type="text" class="form-control" id="peristiwa" name="peristiwa"
                                value="<?= $data['peristiwa'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama_lokasi" class="form-label">Nama lokasi</label>
                            <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi"
                                value="<?= $data['nama_lokasi'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <input type="text" class="form-control" id="detail" name="detail"
                                value="<?= $data['detail'] ?>">
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
                        <a href="<?= base_url('map') ?>" class="w-100 btn btn-danger backBtn">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>