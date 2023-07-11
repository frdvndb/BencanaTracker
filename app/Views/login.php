<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet"
        type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
    <style>
    body {
        background-color: #1546BA;
        background-repeat: no-repeat;
        background-size: cover;
        font-family: "Saira Extra Condensed", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        display: grid;
        place-items: center;
        min-height: 100vh;
    }

    .h3 {
        color: white;
    }

    .form-floating {
        margin-top: 10px;
    }

    .h2w {
        color: white;
    }

    .h2o {
        color: #FF5757;
    }

    .sign-upStyle {
        text-decoration: none;
        color: #bd5d38;
    }
    </style>
</head>

<body>
    <div class="container w-50 ">
        <?php if (session()->get('pesan')) : ?>
        <p><?php echo session()->get('pesan'); ?></p>
        <?php endif; ?>
        <main class="form-signin w-100 m-auto text-center">
            <form action="<?= base_url('login') ?>" method="POST">
                <h2><span class="h2w">Bencana</span><span class="h2o">Tracker</span></h2>
                <?= validation_list_errors() ?>
                <div class="form-floating">
                    <input name="email" type="email" class="form-control" id="floatingInput"
                        placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input name="password" type="password" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 mt-2 btn btn-lg btn-success" type="submit">Sign in</button>
                <p class="fw-bold" style="text-align: center; color:white">Belum punya akun?
                    <a href="<?= base_url('register') ?>" class="sign-upStyle">Sign up</a>
                </p>
            </form>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>
<!-- library SweetAlert -->
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