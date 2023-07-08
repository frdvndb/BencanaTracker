<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BencanaTracker</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    .card {
        margin: auto;
        width: 30%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        position: relative;
        top: 50%;
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
    }

    p {
        color: white;
        font-size: 15px;
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
    h5 {
        color: white;
    }

    h5 {
        margin-bottom: 2px;
        font-weight: bold;
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

    .bottom-left-buttons {
        position: absolute;
        bottom: 20px;
        left: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .bottom-right-buttons {
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .upvote-button,
    .downvote-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        color: white;
    }

    .button-count {
        margin-left: 5px;
    }

    body {
        background-color: #E5E5E5;
    }

    .comment-button a {
        color: white;
        text-decoration: none;
    }

    .report-button a {
        color: white;
        text-decoration: none;
    }

    .scroll-container {
        max-height: 600px;
        overflow-y: auto;
    }

    a[disabled] {
        pointer-events: none;
        cursor: default;
        color: #FF5757;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Bagian sidebar -->
            <div class="col-md-2 sidebar">
                <h2><span class="h2w">Bencana</span><span style="color: #FF5757;">Tracker</span></h2>
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

            <div class="col-md-10 card">
                <div class="scroll-container">
                    <p style="font-size: smaller;">Dilaporkan oleh Andra pada 8 Juli 2023 pukul 13:47 WITA</p>
                    <img src="<?= $gambarSrc ?>" alt="Gambar Peristiwa" class="img-fluid" style="max-height: 300px;">
                    <h5>Peristiwa:</h5>
                    <p><?= $laporan['peristiwa'] ?></p>
                    <h5>Lokasi yang terdeteksi:</h5>
                    <p><?php if (isset($lokasi->display_name)) {
                        echo $lokasi->display_name;
                    } else {
                        echo "Lokasi tidak tersedia";
                    } ?></p>
                    <h5>Lokasi dari pengguna:</h5>
                    <p><?= $laporan['nama_lokasi'] ?></p>
                    <h5>Detail:</h5>
                    <p style="margin-bottom: 50px;"><?= $laporan['detail'] ?></p>

                    <div class="bottom-left-buttons">
                        <?php if (isset($laporan['trusted']) && $laporan['trusted'] == 1): ?>
                        <div style="background-color: #1546BA;">
                            <b style="color: white;">LAPORAN INI TERPERCAYA</b>
                        </div>
                        <?php endif; ?>
                        
                        <button class="upvote-button">
                            <a href="<?= base_url('laporan/upvote/'.$laporan['id']); ?>"
                                <?= isset($dataVote['aksi']) && $dataVote['aksi']  == 'upvote' || $username == null ? 'disabled' : '' ?>>
                                <i class="bi bi-hand-thumbs-up-fill"></i>
                            </a>
                            <span class="button-count"><?= $laporan['jumlah_upvote']?></span>
                        </button>

                        <button class="downvote-button">
                            <a href="<?= base_url('laporan/downvote/'.$laporan['id']); ?>"
                                <?= isset($dataVote['aksi']) && $dataVote['aksi'] == 'downvote' || $username == null ? 'disabled' : '' ?>>
                                <i class="bi bi-hand-thumbs-down-fill"></i>
                            </a>
                            <span class="button-count"><?= $laporan['jumlah_downvote']?></span>
                        </button>
                    </div>

                    <div class="bottom-right-buttons">
                        <button class="report-button">
                            <a href="<?= base_url('/laporkan_laporan/'.$laporan['id']) ?>">
                                <i class="fas fa-exclamation-circle"></i>
                            </a>
                        </button>
                        <button class="comment-button">
                            <a href="<?= base_url('/komentar/'.$laporan['id']) ?>">
                                <i class="fas fa-comment"></i>
                            </a>
                        </button>
                    </div>
                </div>
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