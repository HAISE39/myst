<?php
session_start();
require("config.php");
if (!isset($_SESSION['user'])) {
    if (isset($_POST['login'])) {
        $post_username = $conn->real_escape_string(trim(filter($_POST['username'])));
        $post_password = $conn->real_escape_string(trim(filter($_POST['password'])));

        $check_user = $conn->query("SELECT * FROM users WHERE username = '$post_username' OR email = '$post_username' OR nomer = '$post_username'");
        $check_user_rows = mysqli_num_rows($check_user);
        $data_user = mysqli_fetch_assoc($check_user);

        $verif_pass = password_verify($post_password, $data_user['password']);

        if (!$post_username || !$post_password) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Isi semua form input.');
        } else if ($check_user_rows == 0) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Pengguna Tidak Tersedia.');
        } else if ($data_user['status'] == "Tidak Aktif") {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Akun non aktif hubungi silahkan admin.');
        } else {
            if ($check_user_rows == 1) {
                if ($verif_pass == true) {
                    $conn->query("INSERT INTO log VALUES ('','$post_username', 'Login', '" . get_client_ip() . "','$date','$time')");
                    $_SESSION['user'] = $data_user;
                    exit(header("Location: " . $config['web']['url']));
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username/Password Invalid.');
                }
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
    }
    require 'lib/header_landing.php';
?>
    <div class="wrapper-content">
        <div class="wrapper-content__header">
        </div>
        <div class="wrapper-content__body">
            <!-- Main variables *content* -->
            <div id="block_125">
                <div class="block-bg">
                    <div class="bg-image"></div>
                </div>
                <div class="block-divider-bottom"><svg width="100%" height="100%" viewBox="0 0 1280 140" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                            <path d="M1280 140V0S993.46 140 640 139 0 0 0 0v140z" />
                        </g>
                    </svg></div>
                <div class="container">
                    <div class="block-signin ">
                        <div class="row">
                            <div class="col">
                                <div class="block-signin__content">
                                    <div class="block-signin__title style-text-signin">
                                        <h1 class="text-center"><span style="text-align: CENTER"><span style="color: var(--color-id-231)">PENYEDIA PPOB DAN SMM PANEL INDONESIA</span></span></h1>
                                    </div>
                                    <div class="block-signin__description style-text-signin">
                                        <p class="text-center"><span style="color: var(--color-id-231)"><span style="text-align: CENTER"><?php echo $data['title']; ?></span></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="block-signin__card component_card">
                                    <div class="card">
                                        <?php
                                        if (isset($_SESSION['hasil'])) {
                                        ?>
                                            <div class="alert alert-dismissible alert-<?php echo $_SESSION['hasil']['alert'] ?> mb-3">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <?php echo $_SESSION['hasil']['pesan'] ?>
                                            </div>
                                        <?php
                                            unset($_SESSION['hasil']);
                                        }
                                        ?>
                                        <form method="POST" class="component_form_group component_checkbox_remember_me">
                                            <div class="form-row">
                                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                                <div class="custom-col">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input class="form-control" type="text" name="username" id="username" />
                                                    </div>
                                                </div>
                                                <div class="custom-col">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input class="form-control" type="password" name="password" id="password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="sign-in__remember-me">
                                                        <div class="form-group__checkbox">
                                                            <label class="form-group__checkbox-label">
                                                                <input type="checkbox" name="remember" id="remember">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <label class="form-group__label-title" for="remember">Remember me</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="custom-col">
                                                    <div class="form-group ">
                                                        <div class="sign-in__forgot">
                                                            <a href="/auth/lupa-password">Lupa password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="form-group d-flex component_button_submit ">
                                                        <button class="btn btn-big-primary" type="submit" name="login">MASUK</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="form-group d-flex justify-content-center ">
                                                        <div class="block-signin__remember">
                                                            <p>Belum punya akun?</p>
                                                            <a class="block-signin__link" href="/auth/register">Daftar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="block_116">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center">
                                      Kenapa Harus Di <b class="gradient-text"><?php echo $data['short_title']; ?></b>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center">4 Alasan Kenapa Kamu Harus Memilih <?php echo $data['short_title']; ?>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_120">
                <div class="block-bg"></div>
                <div class="block-divider-bottom"><svg width="100%" height="100%" viewBox="0 0 1280 140" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                            <path d="M1280 140V0S993.46 140 640 139 0 0 0 0v140z" />
                        </g>
                    </svg></div>
                <div class="container">
                    <div class="block-features ">
                        <div class="row align-items-start justify-content-start">
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style=" height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-trophy-alt" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-244);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Kualitas Terjamin</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami memastikan layanan yang terbaik demi kenyamanan pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style=" height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-receipt" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-245);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Metode Pembayaran</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami menerima berbagai metode pembayaran untuk mempermudah pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background:none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style="height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-hands-usd" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-246);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Harga Termurah</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami memberikan harga yang terbaik sesuai dengan kebutuhan pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="
                     background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style="height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-box-heart" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-247);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Proses Pengiriman Cepat</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Semua Orderan Atau Pesanan akan kami proses secepat mungkin.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_98">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center"><span style="text-align: CENTER">Cara Melakukan Pemesanan</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center"><span style="text-align: CENTER">4 Langkah Mudah Untuk Melakukan Pemesanan.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_100">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="how-it-works ">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-end">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-check-double" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-244);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            1
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Lakukan Pendaftaran Akun</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Mulai dengan melakukan pendaftaran di situs kami secara Gratis!</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-start">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-box-check" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-245);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            2
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Deposit Saldo</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Langkah selanjutnya adalah melakukan Deposit. Kami meberima pembayaran Transfer Bank dan E Wallet (Dana, OVO, Gopay, Shopepay) Virtual Account dan Qris</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-end">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;">
                                                            <span class="card__icon-fa far fa-user-circle" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-246);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            3
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Lakukan Pemesanan</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Pilih layanan sosial media yang ingin kamu pesan. Pastikan kamu menginput data yang benar.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-start">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-user-check" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-247);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            4
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Orderan Diproses</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0px;">
                                                            <p>Orderan kamu akan diproses secara otomatis. Kamu dapat memantau statusnya di halaman riwayat.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_97">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="reviews-block ">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="reviews-block__title style-review-card-title">
                                    <h2>Apa yang pelanggan kami katakan</h2>
                                </div>
                                <div class="reviews-block__desc style-review-card-desc">
                                    <p>Ingin tahu tentang pendapat pelanggan lain tentang panel kami? Simak beberapa ulasan mereka berikut ini.</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Tugas saya adalah membantu bisnis agar diperhatikan secara online dan membantu mereka menarik lebih banyak pelanggan dengan cara itu. Layanan SMM yang ditawarkan panel ini membantu saya bekerja lebih cepat!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Dimas Irawan - Member</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Panel SMM ini sungguh luar biasa dalam meningkatkan keterlibatan di akun media sosial Anda! Hal ini dapat dilakukan dengan cepat dan efektif tanpa mengeluarkan banyak uang. Faktanya, layanan di sini sangat murah, sungguh luar biasa!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Alika - Resellers</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Saya membantu berbagai bisnis untuk mendapatkan lebih banyak eksposur online dengan mengelola akun media sosial mereka. Izinkan saya memberi tahu Anda ini: Layanan SMM yang ditawarkan panel ini membantu saya menghemat banyak uang ekstra dan menghasilkan jauh lebih banyak daripada sebelum saya menemukan orang-orang ini.</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Ica Pratiwi - Member</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Memang tidak mudah untuk mendapatkan hasil engagement yang dibutuhkan untuk akun bisnis Anda, apalagi jika Anda masih pemula. Membayar agen SMM bisa menjadi terlalu mahal. Untungnya saya menemukan panel SMM ini, layanan yang saya cari sangat murah di sini!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Yoga Saputra - Resellers</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_113">
                <div class="block-bg">
                    <div class="bg-image"></div>
                </div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center"><span style="text-align: CENTER">Pertanyaan yang sering ditanyakan :</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center"><span style="text-align: CENTER">Staf kami memilih beberapa pertanyaan yang paling sering diajukan tentang panel SMM dan menjawabnya.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_102">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="faq ">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-1" aria-expanded="false" aria-controls="#faq-block-102-1">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Mengapa orang menggunakan panel SMM?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-1">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Panel SMM adalah toko online yang menjual layanan SMM dengan harga terjangkau.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-2" aria-expanded="false" aria-controls="#faq-block-102-2">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Jenis layanan SMM apa yang Anda jual di sini?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-2">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Kami menyediakan berbagai jenis layanan SMM: Followers, Subscriber, Likes , Views dll</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-3" aria-expanded="false" aria-controls="#faq-block-102-3">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah benar aman menggunakan layanan SMM di panel ini?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-3">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Ya, sepenuhnya aman, Anda tidak akan kehilangan akun media sosial Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-4" aria-expanded="false" aria-controls="#faq-block-102-4">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah Layanan SMM Bergaransi?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-4">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Iya, kami memiliki layanan bergaransi dan no refill. Layanan ini berlabel Guaranteed (Bergaransi).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-5" aria-expanded="false" aria-controls="#faq-block-102-5">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah Layanan SMM Ini Otomatis?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-5">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Layanan di sini sudah otomatis. Kamu bisa pantau status orderan di halaman riwayat order.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-6" aria-expanded="false" aria-controls="#faq-block-102-6">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Bagaimana Jika Saya Ada Kendala?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-6">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Jika Anda mengalami kendala saat menggunakan situs kami, kamu bisa langsung chat kami melalui Tiket atau WA. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    require 'lib/footer_landing.php';
} else {
    require 'lib/session_user.php';
    require("lib/header.php");
    ?>
        <div class="content-wrapper">
            <?php
            if (isset($_SESSION['hasil'])) {
            ?>
                <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <b><?php echo $_SESSION['hasil']['judul'] ?></b> <?php echo $_SESSION['hasil']['pesan'] ?>
                </div>
            <?php
                unset($_SESSION['hasil']);
            }
            ?>
            <style>
                .conten-slide {
                    overflow: hidden;
                    border-radius: 15px;
                }

                .slid {
                    width: 100%;
                    display: flex;
                    animation: slide 16s infinite;
                }

                @keyframes slide {
                    0% {
                        transform: translateX(0);
                    }

                    25% {
                        transform: translateX(0);
                    }

                    30% {
                        transform: translateX(-100%);
                    }

                    50% {
                        transform: translateX(-100%);
                    }

                    55% {
                        transform: translateX(-200%);
                    }

                    75% {
                        transform: translateX(-200%);
                    }

                    80% {
                        transform: translateX(-300%);
                    }

                    100% {
                        transform: translateX(-300%);
                    }
                }

                img.sld {
                    width: 100%;
                }
            </style>
            <div class="row" id="beranda">
                <div class="col-sm-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="conten-slide">
                                <div class="slid">
                                    <img class="sld" src="/assets/images/slider/<?php echo $data_banner_slider['slide_1']; ?>">
                                    <img class="sld" src="/assets/images/slider/<?php echo $data_banner_slider['slide_2']; ?>">
                                    <img class="sld" src="/assets/images/slider/<?php echo $data_banner_slider['slide_3']; ?>">
                                    <img class="sld" src="/assets/images/slider/<?php echo $data_banner_slider['slide_4']; ?>">
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                    <div class="col-lg-12">
                    <table class="table table-bordered table-striped">
                    <tbody><tr>
                    <th width="50%">Saldo</th>
                    <td><i class="mdi mdi-cash-multiple text-info"></i> Rp <?php echo number_format($data_user['saldo'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                    <th>Coin <a href="/halaman/tukar-coin">Penukaran</a></th>
                    <td><i class="mdi mdi-coin text-warning"></i> <?php echo $data_kodeReferral['coin']; ?></td>
                    </tr>
                    </tbody></table>
                    </div>
                    </div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card text-center">
                                <table style="border-color: transparent;">
                                    <tbody><br>

                                        <tr>
                                            <th>
                                                <a href="/pemesanan/sosmed">
                                                    <img src="/assets/images/icon-produk/likes.png" height="45" width="45">
                                                </a><a href="/pemesanan/sosmed">
                                                    <h6 class="text-white menunya">Sosmed</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/pulsa">
                                                    <img src="/assets/images/icon-produk/pulse.png" height="45" width="45">
                                                </a><a href="/pemesanan/pulsa">
                                                    <h6 class="text-white menunya">Pulsa</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/paket-data">
                                                    <img src="/assets/images/icon-produk/internet.png" height="45" width="45">
                                                </a><a href="/pemesanan/paket-data">
                                                    <h6 class="text-white menunya">Paket Data</h6>
                                                </a>

                                            </th>
                                        </tr>

                                        <tr>
                                            <th>
                                                <a href="/pemesanan/emoney">
                                                    <img src="/assets/images/icon-produk/ewalet.png" height="45" width="45">
                                                </a><a href="/pemesanan/emoney">
                                                    <h6 class="text-white menunya">Topup E-Money</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/games">
                                                    <img src="/assets/images/icon-produk/voucher.png" height="45" width="45">
                                                </a><a href="/pemesanan/games">
                                                    <h6 class="text-white menunya">Topup Games</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/token-pln">
                                                    <img src="/assets/images/icon-produk/pln.png" height="45" width="45">
                                                </a><a href="/pemesanan/token-pln">
                                                    <h6 class="text-white menunya">Token PLN/Listrik</h6>
                                                </a>

                                            </th>
                                        </tr>

                                        <tr>
                                            <th>
                                                <a href="/pemesanan/tlp-sms">
                                                    <img src="/assets/images/icon-produk/tlpdansms.png" height="45" width="45">
                                                </a><a href="/pemesanan/tlp-sms">
                                                    <h6 class="text-white menunya">Telephone & Sms</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/aktifasi-perdana">
                                                    <img src="/assets/images/icon-produk/aktivasi-perdana.png" height="45" width="45">
                                                </a><a href="/pemesanan/aktifasi-perdana">
                                                    <h6 class="text-white menunya">Aktivasi Perdana</h6>
                                                </a>

                                            </th>
                                            <th>
                                                <a href="/pemesanan/aktifasi">
                                                    <img src="/assets/images/icon-produk/aktivasi-perdana.png" height="45" width="45">
                                                </a><a href="/pemesanan/aktifasi">
                                                    <h6 class="text-white menunya">Tambah Masa Aktif</h6>
                                                </a>

                                            </th>
                                        </tr>

                                        <tr>
                                            <th>
                                                <a href="/pemesanan/voucher">
                                                    <img src="/assets/images/icon-produk/voucher-perdana.png" height="45" width="45">
                                                </a><a href="/pemesanan/voucher">
                                                    <h6 class="text-white menunya">Voucher Data</h6>
                                                </a>

                                            </th>

                                            <th>
                                                <a href="/pemesanan/pertagas">
                                                    <img src="/assets/images/icon-produk/pertagas.png" height="45" width="45">
                                                </a><a href="/pemesanan/pertagas">
                                                    <h6 class="text-white menunya">Pertagas</h6>
                                                </a>

                                            </th>

                                            <th>
                                                <a href="/pemesanan/tv">
                                                    <img src="/assets/images/icon-produk/tv.png" height="45" width="45">
                                                </a><a href="/pemesanan/tv">
                                                    <h6 class="text-white menunya">TV & Streaming</h6>
                                                </a>

                                            </th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box riwayat-pemesanan">
                                <h4 class="card-title text-center b2 bg-dark" style="padding: 10px;">RIWAYAT PEMESANAN PPOB</h4>
                            <?php
                            $cek_orderppob = $conn->query("SELECT * FROM pembelian_ppob WHERE user = '$sess_username' ORDER BY id DESC LIMIT 9");
                            if(mysqli_num_rows($cek_orderppob) == 0){
                            ?>
                            <div class="card corona-gradient-card">
                              <div class="card-body py-0 px-0 px-sm-3">
                                <div class="row align-items-center">
                                  <div class="col-4 col-sm-3 col-xl-2">
                                    <img src="assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                                  </div>
                                  <div class="col-5 col-sm-7 col-xl-8 p-0">
                                    <h4 class="mb-1 mb-sm-0" style="font-size: 1.5vh;">SEPERTINYA KAMU BELUM MELAKUKAN ORDER APAPUN YUK PESAN SEKARANG?</h4>
                                  </div>
                                  <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                                        <img src="/assets/images/hmm.gif" class="gradient-corona-img img-fluid" alt="">
                                    </div>
                                </div>
                              </div>
                            </div>
                            <?php }else{ ?>
                            <?php 
                            while ($data_orderppob = $cek_orderppob->fetch_assoc()) {
                                if ($data_orderppob['status'] == "Pending") {
                                    $label = "warning";
                                } else if ($data_orderppob['status'] == "Processing") {
                                    $label = "primary";
                                } else if ($data_orderppob['status'] == "Success") {
                                    $label = "success";
                                } else if ($data_orderppob['status'] == "Error") {
                                    $label = "danger";
                                } else if ($data_orderppob['status'] == "Partial") {
                                    $label = "danger";
                                }
                            ?>
                                <blockquote class="blockquote blockquote-primary">
                                    <p><?php echo $data_orderppob['layanan']; ?> <span class="float-right text-<?php echo $label; ?>"><?php echo $data_orderppob['status']; ?></span></p>
                                    <footer class="blockquote-footer"><small class="text-muted"> Waktu <?php echo tanggal_indo($data_orderppob['date']); ?> Pukul: <?php echo $data_orderppob['time']; ?> WIB</small></footer>
                                </blockquote>
                            <?php } ?>
                            <?php } ?>
                            </div>
                            <!--<div class="card-box">
                            </div>-->
                        </div><!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    <?php
    require 'lib/footer.php';
}
    ?>