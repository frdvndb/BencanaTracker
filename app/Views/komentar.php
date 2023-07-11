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

    body {
        background-color: #E5E5E5;
    }

    /* .comments-section {
        margin-top: 20px;
        overflow-x: hidden;
        overflow-y: auto;
        max-height: 400px;
    } */
    .user-profile img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
    flex-shrink: 0;
}

.comments-section {
    margin-top: 20px;
    overflow-y: auto;
    max-height: 400px;
    word-break: break-word;
    margin-bottom: 5px;
}

.comments-section::-webkit-scrollbar {
    width: 8px;
    background-color: transparent;
}

.comments-section::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 4px;
}

.comments-section::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255, 255, 255, 0.7);
}

.comments-section::-webkit-scrollbar-track {
    background-color: transparent;
}



    .comment .user-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        color: white;
        word-break: break-word;
    }

    .comments-section h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .comment {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .user-profile {
        display: flex;
    }

    /* .user-profile img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    } */

    .user-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        color: white;
    }

    .comment-actions {
        display: flex;
        align-items: center;
        margin-left: auto;
    }


    /* .like-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .like-button i {
        color: red;
    } */

    .like-count {
        margin-left: 5px;
        font-size: 12px;
        color: white;
    }

    .add-comment textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: vertical;
        margin-bottom: 10px;
    }

    .add-comment .post-button {
        background-color: #00CC99;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
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
                                    class="bi bi-cash-stack"></i> Support Us</a></li>
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

            <?php if ($username == null) { ?>
            <div class="col-md-10 card" style=" width:75%;">
                <h2 style="color:white; text-align:center;">Login Atau Register terlebih dahulu untuk dapat menggunakan
                    fitur ini!</h2>
            </div>
            <?php } else {?>
            <div class="col-md-10 card">
                <div class="comments-section">
                    <h3 style="text-align: center; color: white;">Komentar</h3>
                    <?php if ($dataKomentar == NULL) { ?>
                    <div class="comment" style="color: white; font-weight: 100;">Belum ada komentar...</div>

                    <?php } else {
                    foreach ($dataKomentar as $dk) {  ?>
                    <div class="comment">
                        <div class="user-profile">
                            <div class="user-details" style="margin-left: 10px;">
                                <h5 class="h2o" style="margin-bottom: 0;"><?= $dk['username'] ?> <span
                                        class="like-count"><i class="far fa-calendar-alt"></i> &nbsp;
                                        <?= $dk['tanggal'] ?></span>
                                        <?php if (!$isAdmin == null && $isAdmin == 1) { ?>
                                    <form action="<?= base_url('/hapus_komentar/'.$dk['id']) ?>" method="post"
                                        style="display: inline-block;" onsubmit="return confirm('Yakin Hapus?')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                    </form>
                                    <?php } ?>
                                </h5>
                                <p style="color: white; margin-top: 5px;"><?= $dk['komentar'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } 
                     } 
            }?>

                </div>
                <form action="<?= base_url('komentar/'.$dataLaporan['id']) ?>" method="POST">
                    <div class="add-comment">
                        <textarea class="comment-input" name="komentar" placeholder="Tulis komentar..."
                            style="color: black;"></textarea>
                        <button class="w-100 post-button background-proses">Post</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

</html>