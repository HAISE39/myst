<?php
session_start();
require '../config.php';
if (isset($_POST['id'])) {
    $post_id = $conn->real_escape_string($_POST['id']);
    $cek_layanan = $conn->query("SELECT * FROM layanan_ppob WHERE id = '$post_id'");
    while ($data_layanan = $cek_layanan->fetch_assoc()) {
       if ($data_layanan['status'] == "Normal") {
            $badge = "success";
        } else if($data_layanan['status'] == "Gangguan") {
            $badge = "danger";
        } 
?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-box">
                <tr>
                    <th class="table-detail" width="50%">ID</th>
                    <td class="table-detail"><?php echo $data_layanan['service_id']; ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Tipe</th>
                    <td class="table-detail"><?php echo $data_layanan['tipe']; ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Layanan</th>
                    <td class="table-detail"><?php echo $data_layanan['layanan']; ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Harga</th>
                    <td class="table-detail">Rp <?php echo number_format($data_layanan['harga'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Refill</th>
                    <td class="table-detail">
                        <badge class="badge badge-outline-<?php echo $badge; ?>"><?php echo $data_layanan['status']; ?></badge>
                    </td>
                </tr>
                <tr>
                    <th class="table-detail">Catatan</th>
                    <td class="table-detail"><?= nl2br($data_layanan['catatan']); ?></td>
                </tr>
            </table>
        </div>
<?php
    }
}
?>