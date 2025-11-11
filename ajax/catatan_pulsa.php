<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user'])) {
	die("Anda Tidak Memiliki Akses!");
}
if (isset($_POST['layanan'])) {
	$post_layanan = $conn->real_escape_string($_POST['layanan']);
	$cek_layanan = $conn->query("SELECT * FROM layanan_ppob WHERE provider_id = '$post_layanan' AND status = 'Normal'");
	if (mysqli_num_rows($cek_layanan) == 1) {
		$data_layanan = mysqli_fetch_assoc($cek_layanan);
		?>
		<code><?= nl2br($data_layanan['catatan']); ?></code><br>
		<code>Harga: Rp <?php echo number_format($data_layanan['harga'], 0, ',', '.'); ?></code>
		<?php
	} else {
		?>
		<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="mdi mdi-block-helper"></i>
            <b>Gagal :</b> Service Tidak Ditemukan
        </div>
		<?php
	}
} else {
	?>
	<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="mdi mdi-block-helper"></i>
		<b>Gagal : </b> Terjadi Kesalahan.
	</div>
	<?php
}
