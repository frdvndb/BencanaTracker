<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card {
        margin: auto;
        width: 75%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        background-color: #1546BA;
        margin-top: 3%;
    }

    .container-fluid {
        max-width: 100%;
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

    img {
        width: 50px;
        height: 50px;
    }


    h2 {
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

    .card2 {
        display: flex;
        align-items: center;
        margin: auto;
        width: 100%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        margin-top: 10px;
        background-color: white;
        font-size: 25px;
        position: relative;
    }

    .card2 img {
        width: 80px;
        height: 80px;
        margin-right: 20px;
    }

    .card2 .info-wrapper {
        display: flex;
        flex-direction: column;
        margin-top: -5px;
    }

    .card2 label {
        margin-bottom: -5px;
    }

    .detail-button {
        position: absolute;
        right: 15px;
    }

    body {
        background-color: #E5E5E5;
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
                                    class="bi bi-cash-stack"></i> Donasi</a></li>
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

            <div class="col-md-10 card">
                <h2> Pencarian Relawan </h2>
                <form action="<?= base_url('cariRelawan') ?>" method="GET" class="d-flex">
                    <div class="input-group" style="width: 300px;">
                        <input name="query" type="text" class="form-control"
                            placeholder="Nama Relawan">
                        <button type="submit" class="btn btn-success">Cari</button>
                    </div>
                </form>

                <?php
            foreach ($data as $relawan) { 
                ?>
                <div class="card2">
                    <div class="image-wrapper">
                        <img src="data:image/jpeg;base64,<?= base64_encode($relawan['gambar_relawan']); ?>"
                            class="rounded-circle">
                    </div>
                    <div class="info-wrapper">
                        <span class="nama"><?= $relawan['nama']; ?></span>
                    </div>
                    <div class="detail-button">
                        <a href="<?= base_url('relawan/' . $relawan['id']); ?>" class="btn-detail btn btn-success">Detail</a>
                    </div>
                </div>
                <?php
            } ?>
            </div>
        </div>
    </div>
</body>

</html>