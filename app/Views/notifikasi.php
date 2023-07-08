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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "9c243ca7-57c4-4d7c-9915-888c2167975e",
            });
        });
    </script>
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

        .h2o {
            color: #FF5757;
        }

        label {
            color: white;
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
            cursor: pointer;
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

        .scroll-container {
            max-height: 500px;
            overflow-y: auto;
        }

        #gmapBlock {
            width: 100%;
            height: 300px;
            margin-top: 10px;
        }

        #getLocationButton {
            position: absolute;
            top: 85px;
            right: 30px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
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
                        class="bi bi-cash-stack"></i> Support Us</a></li>
                        <?php if (!$username == null) { ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('logout'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
            <div class="col-md-10 card">
                <h2 style="color:white; text-align:center;">Login Atau Register terlebih dahulu untuk dapat menggunakan
                    fitur ini!</h2>
            </div>
            <?php } else {?>
            <div class="col-md-10 card">
                <div class="row">
                    <div class="col-md-6">
                        <h2> Notifikasi </h2>
                    </div>
                    <div class="col-md-6">
                        <div id="loading" style="display: none;" class="text-end">
                            <div class="spinner-border text-primary" role="status" style="margin-left: 440px;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="scroll-container">
                            <?php if (empty($data)) { ?>
                                <p>Belum ada notifikasi</p>
                            <?php } else { ?>
                                <?php foreach ($data as $item) { ?>
                                    <div id="notifCard<?= $item['id_laporan']; ?>" class="card2">
                                        <div class="image-wrapper">
                                            <img src="data:image/jpeg;base64,<?= base64_encode($item['gambar_peristiwa']); ?>"
                                                class="rounded-circle">
                                        </div>
                                        <div class="info-wrapper">
                                            <span class="nama"><?= $item['peristiwa']; ?></span>
                                        </div>
                                        <div class="detail-button">
                                            <a href="<?= base_url('laporan/' . $item['id_laporan']); ?>"
                                                class="btn-detail btn btn-success">Detail</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6" id="mapContainer">
                        <div id="gmapBlock"></div>
                        <button id="getLocationButton" class="btn btn-primary">
                            <i class="bi bi-geo-alt-fill"></i> Lokasi Saya
                        </button>
                        <p>Klik pada peta untuk mengganti lokasi Anda. Klik salah satu notifikasi untuk menampilkan lokasi laporannya.</p>
                        <div id="subscriptionContainer">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="emailSwitch" name="emailSubscribe" <?= $emailSub['email_subscribe'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="emailSwitch">Subscribe Email</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pushSwitch" name="pushSubscribe" <?= $pushSub['push_subscribe'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="pushSwitch">Subscribe Notifikasi Push</label>
                        </div>
                            <div class="radiusContainer">
                                <label for="radiusInput" style="margin-top: 10px;">Radius Notifikasi (km)</label>
                                <?php 
                                if (isset($tanggalPremium) && $tanggalPremium != NULL){
                                    $tanggalNotifikasi = $tanggalPremium['tanggal_premium'];
                                } else {
                                    $tanggalNotifikasi = '2020-07-10';
                                }
                                $tanggalNotifikasiTes = '2020-07-10';
                                if (strtotime($tanggalNotifikasi) > time()) { ?>
                                <div class="input-group mb-3"> 
                                    <input type="number" class="form-control" id="radiusInput" placeholder="<?= $radiusNotif['radius_notif'] ? $radiusNotif['radius_notif'] : 5 ?>">
                                    <button class="btn btn-primary" id="radiusButton">Ubah Radius (Premium)</button>
                                </div>
                                <?php } else { ?>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="radiusInput" placeholder="<?= $radiusNotif['radius_notif'] ? $radiusNotif['radius_notif'] : 5 ?>">
                                    <a href="<?= base_url('/belip') ?>" class="btn btn-primary">Ubah Radius. (Premium)</a>
                                </div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
                    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
                    crossorigin=""></script>

                <script>
                    var lingkaran = <?= $radiusNotif['radius_notif'] ? $radiusNotif['radius_notif'] : 5 ?>
                    // retrieve user location from the database
                    var userLocation = <?php echo json_encode($lokasiUser); ?>;

                    var map = L.map('gmapBlock').setView([-3.89, 115.28], 2);

                    // set map tiles source
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                        maxZoom: 18
                    }).addTo(map);

                    // add marker for user location
                    var marker = L.marker([userLocation.garis_lintang, userLocation.garis_bujur]).addTo(map);

                    // create a circle with 5 kilometer radius around the marker
                    var circle = L.circle([userLocation.garis_lintang, userLocation.garis_bujur], {
                        color: 'orange',
                        fillColor: 'orange',
                        fillOpacity: 0.2,
                        radius: 1000 * lingkaran
                    }).addTo(map);

                    // animate zoom to user location
                    map.flyTo([userLocation.garis_lintang, userLocation.garis_bujur], 12, {
                        animate: true,
                        duration: 3 // durasi animasi dalam detik
                    });

                    var getLocationButton = document.getElementById('getLocationButton');
                    getLocationButton.addEventListener('click', getUserLocation);

                    // Get user's current location
                    function getUserLocation() {
                        if ("geolocation" in navigator) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var latitude = position.coords.latitude;
                                var longitude = position.coords.longitude;

                                var circleUserLocation = L.circle([latitude, longitude], {
                                    color: 'red',
                                    fillColor: 'red',
                                    fillOpacity: 1,
                                    radius: 1
                                }).addTo(map);
                                // animate zoom to user location
                                map.flyTo([latitude, longitude], 13, {
                                    animate: true,
                                    duration: 3 // durasi animasi dalam detik
                                });
                            });
                        } else {
                            console.log('Geolocation is not supported by this browser.');
                        }
                    }

                    // event handler for clicking on the map to update the user location
                    map.on('click', function(event) {
                        var clickedLocation = event.latlng;
                        var latitude = clickedLocation.lat;
                        var longitude = clickedLocation.lng;

                        // update user location in the database
                        $.ajax({
                            url: '<?= base_url("update_lokasi_user"); ?>',
                            method: 'POST',
                            data: {
                                latitude: latitude,
                                longitude: longitude
                            },
                            beforeSend: function() {
                                // Tampilkan elemen loading
                                $('#loading').show();
                            },
                            success: function(response) {
                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                // remove previous marker and circle
                                map.removeLayer(marker);
                                map.removeLayer(circle);

                                // add new marker for updated location
                                marker = L.marker(clickedLocation).addTo(map);

                                // create a new circle with 5 kilometer radius around the marker
                                circle = L.circle(clickedLocation, {
                                    color: 'orange',
                                    fillColor: 'orange',
                                    fillOpacity: 0.2,
                                    radius: 1000 * lingkaran
                                }).addTo(map);

                                // Tampilkan pesan popup menggunakan SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Berhasil Memperbarui Lokasi.'
                                });
                            },
                            error: function() {
                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                alert('Error updating user location!');
                            }
                        });
                    });

                    // Function to handle subscription change
                    function handleSubscriptionChange(type, value) {
                        // Update subscription status in the database
                        $.ajax({
                            url: '<?= base_url("update_status_langganan"); ?>',
                            method: 'POST',
                            data: {
                                type: type,
                                value: value
                            },
                            beforeSend: function() {
                                // Tampilkan elemen loading
                                $('#loading').show();
                            },
                            success: function(response) {
                                if (type == 'push' && value == true) {
                                    pushCheckbox.checked = true;
                                }
                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                // Tampilkan pesan popup menggunakan SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Berhasil Mengubah Status Berlangganan.'
                                });
                            },
                            error: function() {
                                if (type == 'email') {
                                    emailCheckbox.checked = initialStatusEmail;
                                } else if (type == 'push') {
                                    pushCheckbox.checked = initialStatusPush;
                                }
                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                alert('Error updating subscription status!');
                            }
                        });
                    }

                    var emailCheckbox = document.getElementById('emailSwitch');
                    var pushCheckbox = document.getElementById('pushSwitch');

                    var initialStatusEmail = emailCheckbox.checked;
                    var initialStatusPush = pushCheckbox.checked;

                    // event handler for email subscription switch
                    $('#emailSwitch').on('change', function() {
                        var isChecked = $(this).prop('checked');
                        handleSubscriptionChange('email', isChecked);
                    });

                    // event handler for push notification subscription switch
                    $('#pushSwitch').on('change', function() {
                        var isChecked = $(this).prop('checked');
                        if (isChecked) {
                            // pushCheckbox.checked = false;
                            OneSignal.push(["getNotificationPermission", function(permission) {
                                console.log("Site Notification Permission:", permission);
                                if (permission == 'granted') {
                                    handleSubscriptionChange('push', isChecked);
                                } else if (permission == 'denied') {
                                    alert('Anda telah memblokir notifikasi web push. Silahkan mengizinkan notifikasi untuk BencanaTracker di setelan brwser.')
                                    pushCheckbox.checked = false;
                                } else {
                                    alert('Silahkan mengizinkan notifikasi untuk perangkat ini. Jika permintaan izin tidak muncul, Anda dapat mengizinkannya di \"Site Permission\" untuk BencanaTracker di setelan browser.')
                                    // Prompt for OneSignal permission
                                    OneSignal.push(function() {
                                        OneSignal.showNativePrompt();
                                    });
                                    handleSubscriptionChange('push', isChecked);
                                }
                            }]);
                        } else {
                            handleSubscriptionChange('push', isChecked);
                        }
                    });

                    function checkSubscriptionAndSavePlayerID() {
                        // Check if the user is logged in
                        var isLoggedIn = <?php echo $username ? 'true' : 'false'; ?>;
                        var userID = "<?php echo $userID; ?>";
                        if (isLoggedIn) {
                            OneSignal.push(function() {
                                OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                                    if (isEnabled) {
                                        console.log("Push notifications are enabled!");
                                        $('#loading').show();
                                        // Check if the user is already subscribed
                                        OneSignal.getUserId(function(userId) {
                                            if (userId) {
                                                // User is subscribed, save the player ID to the database
                                                savePlayerID(userId, userID); // Pass the user ID to the savePlayerID function
                                            }
                                        });
                                    }
                                    else {
                                        console.log("Push notifications are not enabled yet.");    
                                        $('#loading').hide();
                                    }
                                });
                            });
                        }
                    }

                    // Function to save the player ID to the database
                    function savePlayerID(playerId, userID) { // Add userID as a parameter
                        // Send an AJAX request to your server to save the player ID to the database
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?= base_url() ?>' + '/simpan_player_id', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                console.log('Player ID saved successfully');
                            }
                            $('#loading').hide();
                        };
                        xhr.send('playerId=' + playerId + '&userID=' + userID); // Send the user ID along with the player ID
                    }


                    OneSignal.push(function () {
                        OneSignal.on('subscriptionChange', function (isSubscribed) {
                            console.log("The user's subscription state is now:", isSubscribed);
                            if (isSubscribed == true) {
                                checkSubscriptionAndSavePlayerID();
                            } else if (isSubscribed == false) {
                                pushCheckbox.checked = initialStatusPush;
                            }
                        });
                    });

                    checkSubscriptionAndSavePlayerID();

                    // event handler for radius button click
                    $('#radiusButton').on('click', function() {
                        event.preventDefault(); // Menghentikan aksi default tombol
                        var radius = $('#radiusInput').val();

                        // Update radius in the database
                        $.ajax({
                            url: '<?= base_url("update_radius"); ?>',
                            method: 'POST',
                            data: {
                                radius: radius
                            },
                            beforeSend: function() {
                                // Tampilkan elemen loading
                                $('#loading').show();
                            },
                            success: function(response) {
                                lingkaran = radius;

                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                // Update circle radius on the map
                                circle.setRadius(radius * 1000);

                                // Tampilkan pesan popup menggunakan SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Berhasil Mengubah Radius Notifikasi.'
                                });
                            },
                            error: function() {
                                // Sembunyikan elemen loading
                                $('#loading').hide();

                                alert('Error updating radius!');
                            }
                        });
                    });
                    var notificationMarker; // Variabel untuk menyimpan marker notifikasi

                    customIcon = L.icon({
                        iconUrl: "<?= base_url('../assets/img/placeholder.png') ?>",
                        iconSize: [32, 32],
                        iconAnchor: [15, 30],
                    });

                    <?php foreach ($data as $item) { ?>
                    $('#notifCard<?= $item['id_laporan']; ?>').click(function() {
                        var lat = <?= $item['garis_lintang']; ?>;
                        var lng = <?= $item['garis_bujur']; ?>;

                        // Hapus marker notifikasi sebelumnya (jika ada)
                        if (notificationMarker) {
                            map.removeLayer(notificationMarker);
                        }

                        // Add new marker for selected location
                        notificationMarker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

                        // Animate flyTo to the selected marker location
                        map.flyTo([lat, lng], 12, {
                            animate: true,
                            duration: 2
                        });
                    });
                    <?php } ?>
                </script>
            </div>
            <?php } ?>
        </div>
    </div>
    </body>
</html>
