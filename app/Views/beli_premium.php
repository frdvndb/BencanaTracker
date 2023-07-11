<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        margin: auto;
        width: 50%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        margin-top: 70px;
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
        margin-left: 50px;
    }

    .text-primary {
        --bs-primary-rgb: 189, 93, 56;
        --bs-text-opacity: 1;
        color: rgba(var(--bs-primary-rgb), var(--bs-text-opacity)) !important;
    }

    .h2w {
        color: white;
    }

    .h2o {
        color: #FF5757;
    }

    label {
        color: darkorange;
        font-weight: bold;
    }

    .laporButton {
        background-color: white;
        color: #FF5757;
        font-weight: bold;
        width: 100%;
        margin-top: 40px;
    }

    .field {
        background-color: black;
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

    .custom-radio input[type="radio"] {
        display: none;
    }

    .card2 {
        align-items: center;
        width: 100%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 5px;
        background-color: darkorange;
        font-size: 15px;
        position: relative;
    }

    .custom-radio input[type="radio"]+label {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 0.375rem 0.75rem;
        cursor: pointer;

        background-color: white;
    }

    .custom-radio input[type="radio"]:checked+label {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    body {
        background-color: #E5E5E5;
    }

    .mt-3 p {
        color: white;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .container img {
        border-radius: 50%;
        margin-right: 10px;
        max-height: 50px;
        max-width: 50px;
    }

    .background-proses {
        background-color: #00cc99;
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
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('beli_premium'); ?>"><i
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
            <div class="col-md-10">
                
                    <?php if ($username == null) { ?>
                    <div class="card">
                        <h2 style="color:white; text-align:center;">Login Atau Register terlebih dahulu untuk dapat
                            menggunakan fitur ini!</h2>
                    </div>
                    <?php } else { ?>
                    <div class="card">
                        <div class="container">
                            <center>
                                <h1 style="color: darkorange;">Pembelian Premium</h1>
                            </center>
                            <img src="assets/img/BencanaTracker.png" alt="Deskripsi Gambar" class="img-fluid"
                                style="max-height:50px; max-width: 50px;">
                        </div>
                        <div class="mt-3">
                            <p>1 Bulan = Rp30.000,00</p>
                            <p>Premium akan dimulai ketika Admin telah menyetujui pembelian.</p>
                            <p>Lakukan pembayaran kepada rekening berikut:</p>
                            <p>Rekening BRI:</p>
                            <p class="card2">048292302291</p>
                            <p>Rekening BNI:</p>
                            <p class="card2">048532302291</p>
                        </div>
                        <!-- Form Support Us -->
                        <div class="mt-3">
                            <form action="belip" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="jumlah_bulan" class="form-label">Jumlah Bulan</label>
                                    <input type="text" class="form-control" id="jumlah_bulan" placeholder="Jumlah Bulan"
                                        name="jumlah_bulan" required>
                                </div>
                                <div class="form-group">
                                    <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label>
                                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                                        class="form-control">
                                </div><br>
                                <button type="submit" class="btn btn-primary w-100 background-proses">Beli</button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                
            </div>
        </div>
    </div>
</body>
<!-- library SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Cek flash data 'failed' -->
<?php if (session()->getFlashdata('failed')): ?>
    <script>
        // Tampilkan pesan popup menggunakan SweetAlert
        Swal.fire({
            icon: 'failed',
            title: 'Ini Fitur Premium!',
            text: '<?= session()->getFlashdata('failed') ?>'
        });
    </script>
<?php endif; ?>
</html>