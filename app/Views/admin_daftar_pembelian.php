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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
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

    table img {
        height: 30px;
        width: 60px;
    }

    .pagination-links {
        display: flex;
        justify-content: left;
        margin-left: 10px;
        height: 20px;
    }

    .pagination-links .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination-links .pagination .active {
        background-color: #FF5757;
        color: white;
    }

    .pagination-links .pagination li {
        margin-right: 5px;
    }

    .pagination-links .pagination a {
        display: inline-block;
        padding: 5px 10px;
        background-color: white;
        color: #FF5757;
        border: none;
        text-decoration: none;
        font-weight: bold;
        cursor: pointer;
    }

    .pagination-links .pagination a:hover {
        background-color: #FF5757;
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
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_pelaporan'); ?>"><i
                                    class="bi bi-flag"></i> Daftar Pelaporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_relawan'); ?>"><i
                                    class="bi bi-people-fill"></i> Daftar Relawan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin_daftar_pembelian'); ?>"><i
                                    class="bi bi-bar-chart"></i> Daftar Pembelian</a></li>
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
                <h1>Daftar Laporan Bencana</h1>
                <form action="<?= base_url('admin_daftar_lb') ?>" method="GET" class="d-flex">
                    <div class="input-group" style="width: 300px;">
                        <input name="query" type="text" class="form-control" placeholder="Cari Bencana"
                            value="<?= $query ?>">
                        <button type="submit" class="btn btn-success">Cari</button>
                    </div>
                </form>

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID Pengguna</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Jumlah Bulan</th>
                                <th>Bukti Pembayaran</th>
                                <th>Tanggal Pembelian</th>
                                <th>Premium?</th>
                                <th>Notifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Perulangan foreach()
                    untuk memanggil memanggil
                    semua data yang diperlukan. -->
                            <?php $i = 0 + (10 * ($currentPage - 1)); ?>
                            <?php foreach ($data as $data) : ?>
                            <tr>
                                <td><?= $i+=1; ?></td>
                                <td><?= $data['id_user'] ?></td>
                                <td><?= $data['username'] ?></td>
                                <td><?= $data['email'] ?></td>
                                <td><?= $data['jumlah_bulan'] ?></td>
                                <td><img src="data:image/jpeg;base64,<?= base64_encode($data['bukti_pembayaran']); ?>">
                                </td>
                                <td><?= $data['waktu_pembelian'] ?></td>
                                <td><?php
                                if (!isset($data['tanggal_premium']) && $data['tanggal_premium'] == NULL || $data['tanggal_premium'] == '0000-00-00'){
                                    echo "Tidak";
                                }else{
                                    echo $data['tanggal_premium'];
                                }
                                 ?></td>
                                <td><?php 
                                if ($data['notifikasi'] == 0){
                                    echo "Tidak";
                                }else{
                                    echo 'Sudah';
                                }
                                 ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="<?= base_url('verifikasi_pembelian/'.$data['id']) ?>"
                                                class="btn btn-warning">Verifikasi</a>
                                            <?php 
                                            if (isset($data['tanggal_premium']) && $data['tanggal_premium'] !== NULL && $data['tanggal_premium'] !== '0000-00-00'){ ?>
                                            <a class="dropdown-item"
                                                href="<?= base_url('batalkan_verifikasi_pembelian/'.$data['id_user']) ?>"
                                                class="btn btn-warning">Batalkan Verifikasi</a>
                                            <?php }
                                            ?>
                                            <a class="dropdown-item"
                                                href="<?= base_url('buat_notif_pembelian/'.$data['id']) ?>"
                                                class="btn btn-warning">Notifikasi ke User</a>
                                            <form action="<?=  base_url('/hapus_pembelian/'.$data['id']) ?>"
                                                method="post" onsubmit="return confirm('Yakin Hapus?')">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="dropdown-item" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                </div>
                <div class="ml-auto">
                    <div class="pagination-links">
                        <?= $pager->links() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Initialize the dropdown
        $('.dropdown-toggle').dropdown();

        // Close dropdown when clicking outside
        $(document).on('click', function(event) {
            var target = $(event.target);
            if (!target.closest('.dropdown').length && !target.hasClass('dropdown-toggle')) {
                $('.dropdown-toggle').each(function() {
                    if ($(this).siblings('.dropdown-menu').hasClass('show')) {
                        $(this).dropdown('toggle');
                    }
                });
            }
        });
    });
    </script>
</body>

</html>