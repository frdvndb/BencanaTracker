<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codeigniter 4 Show Multiple Markers on Google Map Example</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .card {
    margin: auto;
    width: 30% ;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    padding: 20px;
    margin-top: 150px;
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
      .h2o,label {color: #FF5757;}
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
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('donasi'); ?>">Donasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Logout</a></li>
                    </div>
                    <div class="bottom-sidebar">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url(''); ?>">Farid</a></li>
                    </div>
                </ul>
            </div>

            <div class="col-md-10 card">
              <center><h1> Donasi </h1></center>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <form action="" method="post">
						<div class="mt-3">
							<label class="form-label">Jumlah uang:</label>
              <input type="text" name="jumlah" placeholder="Masukkan jumlah uang" required class="form-control col-form-label-sm background-input">
						</div>
            <div class="mt-3">
							<label class="form-label">Metode Pembayaran</label> <br>
              <button class="rounded">BNI</button>
                <button class="rounded">BRI</button>
                <div class="mt-3">
                <input type="text" name="nomor_rekening" placeholder="Nomor Rekening" required class="form-control col-form-label-sm background-input"><br></div>
						</div>
            <div class="mt-3">
              <center><input type="submit" name="proses" value="Proses" class="btn btn-outline-success btn-lg text-white background-proses"></center>
						</div>
            </div>

</body>
</html>
