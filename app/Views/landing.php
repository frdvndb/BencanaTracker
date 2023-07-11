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
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
        <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "b2a2b678-e517-474d-9e66-f23ab88930b2",
            });
        });

        // Fungsi untuk memeriksa apakah pengguna berlangganan, dan menyimpan ID pemain
        function checkSubscriptionAndSavePlayerID() {
            // Cek apakah pengguna sudah login
            var isLoggedIn = <?php echo $username ? 'true' : 'false'; ?>;
            var userID = "<?php echo $userID; ?>";
            if (isLoggedIn) {
                OneSignal.push(function() {
                    OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                        if (isEnabled) {
                            console.log("Push notifications are enabled!");
                            document.getElementById('loading').style.display = 'flex';
                            // Cek apakah pengguna sudah subscribed
                            OneSignal.getUserId(function(userId) {
                                if (userId) {
                                    // Pengguna berlangganan, simpan ID pemain ke database
                                    var playerId = OneSignal.getRegistrationId();
                                    savePlayerID(userId, userID); // Berikan ID pengguna ke fungsi savePlayerID
                                }
                            });
                        }
                        else {
                            console.log("Push notifications are not enabled yet.");    
                            document.getElementById('loading').style.display = 'none';
                        }
                    });
                });
            }
        }

        // Fungsi untuk menyimpan ID pemain ke database
        function savePlayerID(playerId, userID) { 
            // Kirim permintaan AJAX ke server untuk menyimpan ID pemain ke database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url() ?>' + '/simpan_player_id', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                // alert(xhr.readyState + " " + xhr.status)
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Player ID saved successfully');
                    document.getElementById('loading').style.display = 'none';
                }
            };
            xhr.send('playerId=' + playerId + '&userID=' + userID); // Kirim user ID bersama player ID
        }

        OneSignal.push(function() {
            // Terjadi bila langganan pengguna berubah ke nilai baru
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                console.log("The user's subscription state is now:", isSubscribed);
                checkSubscriptionAndSavePlayerID();
            });
        });

        // Panggil fungsi saat halaman dimuat
        window.onload = checkSubscriptionAndSavePlayerID;
        </script>    
    <style>
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


    .text-primary {
        --bs-primary-rgb: 189, 93, 56;
        --bs-text-opacity: 1;
        color: rgba(var(--bs-primary-rgb), var(--bs-text-opacity)) !important;
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

    h1 {
        text-transform: uppercase;

    }

    .h2w {
        color: white;
    }

    .h2o {
        color: #FF5757;
    }

    .content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        padding: 20px;
        background-image: url('<?= base_url(); ?>assets/img/bglanding.jpeg');
        background-color: #E5E5E5;
        background-size: cover;
        background-position: center;
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-weight: 500;
        color: white;
    }

    .card {
        display: flex;
        align-items: center;
        margin: auto;
        width: 100%;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        padding: 20px;
        background-color: rgba(21, 70, 186, 0.8);
        position: relative;
        text-align: center;
    }

    .loading {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        color: #FF5757;
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
            <!-- Bagian konten -->
            <div class="col-md-10 content">
                <div class="card">
                    <h1>Selamat Datang di BencanaTracker</h1>
                    BencanaTracker adalah website yang dirancang untuk melacak dan melaporkan bencana yang terjadi.
                    Melalui platform ini, pengguna dapat membuat laporan tentang bencana yang terjadi dekat mereka,
                    mencari relawan untuk membantu dalam penanganan bencana, dan berbagai hal lainnya.
                    Untuk melaporkan bencana, Anda dapat menggunakan tombol "LAPORKAN BENCANA" yang terdapat pada
                    sidebar
                    sebelah kiri. Selain itu, Anda juga dapat menggunakan fitur-fitur lain yang tersedia pada sidebar
                    untuk menjelajahi website ini.
                </div>
            </div>
        </div>
    </div>
    <div class="loading" id="loading">
        <h3>Sinkronisasi akun dan notifikasi, mohon tunggu...</h3>
    </div>
</body>

</html>