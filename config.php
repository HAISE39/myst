<?php

//<!--

// YOUTUBE CODING KEBUMEN //

// PHONE 083191910986 //

// DI LARANG KERAS MEMPERJUALBELIKAN SCRIPT INI TANPA IZIN //

//-->

date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
$maintenance = 1; //** 1 = ya ..  0 = tidak
if($maintenance == 0) {
    die("Site under Maintenance.");
}
// database
$config['db'] = array(
	'host' => 'localhost',
	'name' => 'sakurupi_ppob',
	'username' => 'sakurupi_ppob',
	'password' => 'sakurupi_ppob'
);

$conn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
if(!$conn) {
	die("Koneksi Gagal : ".mysqli_connect_error());
	}
$config['web'] = array(
	'url' => 'https://sakurupiah.my.id/' // isi domain anda : https://domain.com/
	
);	
// date & time
$date = date("Y-m-d");
$time = date("H:i:s");
// date & time
$tanggal = date("Y-m-d");
$waktu = date("H:i:s");
require("lib/function.php");
$version_update = "?v=1.1"; //?v=1.1 update setiap kali melakukan perubahan
?>

























