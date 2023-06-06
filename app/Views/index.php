<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codeigniter 4 Show Multiple Markers on Google Map Example</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        background-color: red;
        padding: 20px;
        font-size: 1.5rem;
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

      h1 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 700;
        line-height: 1.2;
        font-size: calc(1.725rem + 5.7vw);
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
      .h2w {color: white;}
      .h2o {color: #FF5757;}
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
                        <a class="btn btn-primary laporButton" style="color: #FF5757;" href="<?= base_url(''); ?>">LAPORKAN<br> BENCANA</a>
                    </li>
                    <div class="main-sidebar">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('beranda'); ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Notifikasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Pencarian Relawan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Histori Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Donasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Logout</a></li>
                    </div>
                    <div class="bottom-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Farid</a></li>
                    </div>
                </ul>
            </div>
            <!-- Bagian konten -->
            <div class="col-md-10 content">
                <div id="gmapBlock"></div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(function() {
                        var script = document.createElement('script');
                        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyA85_vUbvIQtqVIFFKYjESeKJpK_rr_rVg&sensor=false&callback=initialize";
                        document.body.appendChild(script);
                    });
                    
                    function initialize() {
                        var map;
                        var bounds = new google.maps.LatLngBounds();
                        var mapOptions = {
                            mapTypeId: 'roadmap'
                        };

                        map = new google.maps.Map(document.getElementById("gmapBlock"), mapOptions);
                        map.setTilt(45);

                        var locationMarkers = JSON.parse(`<?php echo ($locationMarkers); ?>`);

                        var locInfo = JSON.parse(`<?php echo ($locInfo); ?>`);

                        var infoWindow = new google.maps.InfoWindow(), marker, i;
                        var clickedMarker = null;

                        for( i = 0; i < locationMarkers.length; i++ ) {
                            var position = new google.maps.LatLng(locationMarkers[i][1], locationMarkers[i][2]);
                            bounds.extend(position);
                            marker = new google.maps.Marker({
                                position: position,
                                map: map,
                                title: locationMarkers[i][0]
                            });

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infoWindow.setContent(locInfo[i][0]);
                                    infoWindow.open(map, marker);
                                }
                            })(marker, i));

                            map.fitBounds(bounds);
                        }

                        google.maps.event.addListener(map, 'click', function(event) {
                            var clickedLocation = event.latLng;
                            var marker = new google.maps.Marker({
                                position: clickedLocation,
                                map: map,
                                title: 'Clicked Location'
                            });

                            var locationName = prompt("Bencana yang terjadi:");
                            var latitude = clickedLocation.lat();
                            var longitude = clickedLocation.lng();

                            if (locationName !== null && locationName !== "") {
                                $.post("", {location_name: locationName, latitude: latitude, longitude: longitude}, function(data) {
                                    // Refresh the page to update the markers
                                    location.reload();
                                });
                            } else {
                                // Remove the marker if location name is not provided
                                marker.setMap(null);
                            }
                        });

                        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                            this.setZoom(5);
                            google.maps.event.removeListener(boundsListener);
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</body>
</html>
