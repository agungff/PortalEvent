<?php
	session_start();

	if (!isset($_SESSION['id']) && isset($_GET['id']) && !empty($_GET['id'])) {
		include '../includes/function_database.php';
		include '../includes/constant.php';

		$kode = $_GET['id'];
		$email = aktivasi($kode);

		if ($email != false) {
			$body = '<strong>Aktivasi Akun</strong><br>'
			.'Akun Anda sudah aktif. Silahkan login untuk menggunakan layanan kami.';
			kirimEmail($email, 'Aktivasi', $body);

			setcookie('aktivasi', 1, time()+1);
		}
	}

	header('location: /');
?>