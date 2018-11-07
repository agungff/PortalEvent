<?php
	session_start();
	include_once '../includes/constant.php';

	if (!isset($_SESSION['id']) || $_SESSION['hakAkses']!=HAK_AKSES_MEMBER) {
		header('location: /');
	}

	$eventId = isset($_COOKIE['eventId']) ? $_COOKIE['eventId'] : '';
	$jumlahReguler = isset($_COOKIE['jumlahReguler']) ? $_COOKIE['jumlahReguler']: 0;
	$jumlahSilver = isset($_COOKIE['jumlahSilver']) ? $_COOKIE['jumlahSilver'] : 0;
	$jumlahGold = isset($_COOKIE['jumlahGold']) ? $_COOKIE['jumlahGold'] : 0;

	include_once '../includes/function_database.php';
	$event = getEventById($eventId);

	if (!isset($event)) {
		header('location: /');
	}

	$kode = round(microtime(true));
	if (isset($_POST['submit'])) {
		$total = $_POST['total'];
		tambahPesanan($kode, $_SESSION['id'], $event[EVENT_ID], $jumlahReguler, $jumlahSilver, $jumlahGold, $total);
		$body =
		'<pre>
			<strong>DETAIL TIKET</strong>
			Kode tiket    : <strong>'.$kode.'</strong>
			Nama event    : '.$event[EVENT_NAMA].'
			Lokasi        : '.$event[EVENT_LOKASI].'
			Waktu mulai   : '.$event[EVENT_WAKTU_MULAI].'
			Waktu selesai : '.$event[EVENT_WAKTU_SELESAI].'
			Tiket dibeli  : <strong>'.$jumlahReguler.' Reguler, '.$jumlahSilver.' Silver, dan '.$jumlahGold.' Gold</strong>
		</pre><br>
		<pre>
			<strong>DETAIL PEMBAYARAN</strong>
			Total tagihan  : <strong>'.$total.'</strong>
			Bank tujuan    : BRI
			Nomor rekening : xxx-xxx-xxx-xxx
			Atas nama      : Agung Febriyanto
		</pre>';

		kirimEmail($_SESSION['email'], 'Pemesanan Tiket', $body);
		setcookie('pesan', 1, time()+1);
		header('location: /');
	}

	include '../templates/header.html.php';
?>
<title>Pesanan</title>
</head>
<body>
	<?php include '../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel-group">
				    <div class="panel panel-primary">
				      	<div class="panel-heading text-center"><strong><?= $event[EVENT_NAMA] ?></strong></div>
				      	<div class="panel-body">
				      		<img src="/images/<?= $event[EVENT_GAMBAR] ?>" class="img-responsive" style="width:100%" alt="Image"><br>
				      		<strong>Tentang Event :</strong><br>
				      		<?= $event[EVENT_DESKRIPSI] ?><br><br>
				      		<strong>Lokasi :</strong><br>
				      		<?= $event[EVENT_LOKASI] ?><br><br>
				      		<strong>Acara Mulai :</strong><br>
				      		<?= $event[EVENT_WAKTU_MULAI] ?><br><br>
				      		<strong>Acara Selesai :</strong><br>
				      		<?= $event[EVENT_WAKTU_SELESAI] ?><br><br>
				      		<table class="table table-bordered text-center">
				      			<thead>
				      				<tr>
				      					<th class="text-center">Jenis Tiket</th>
				      					<th class="text-center">Harga Tiket</th>
				      					<th class="text-center">Jumlah Beli</th>
				      					<th class="text-center">Total Per Satuan</th>
				      				</tr>
				      			</thead>
				      			<tbody>
				      				<?php if($event['hargaReguler'] != 0): ?>
				      					<tr>
				      						<td>Reguler</td>
				      						<td><?= $event['hargaReguler'] ?></td>
				      						<td><?= $jumlahReguler ?></td>
				      						<td><?= $event['hargaReguler']*$jumlahReguler ?></td>
				      					</tr>
				      				<?php endif ?>
				      				<?php if($event['hargaSilver'] != 0): ?>
				      					<tr>
				      						<td>Silver</td>
				      						<td><?= $event['hargaSilver'] ?></td>
				      						<td><?= $jumlahSilver ?></td>
				      						<td><?= $event['hargaSilver']*$jumlahSilver ?></td>
				      					</tr>
				      				<?php endif ?>
				      				<?php if($event['hargaGold'] != 0): ?>
				      					<tr>
				      						<td>Gold</td>
				      						<td><?= $event['hargaGold'] ?></td>
				      						<td><?= $jumlahGold ?></td>
				      						<td><?= $event['hargaGold']*$jumlahGold ?></td>
				      					</tr>
				      				<?php endif ?>
				      				<tr>
				      					<td colspan="3" class="text-right"><strong>TOTAL BAYAR</strong></td><?php $total = $event['hargaReguler']*$jumlahReguler+$event['hargaSilver']*$jumlahSilver+$event['hargaGold']*$jumlahGold; ?>
				      					<td><?= $total ?></td>
				      				</tr>
				      			</tbody>
				      		</table>
				      		<form action="" method="post">
				      			<input type="hidden" name="total" value="<?= $total ?>">
				      			<div class="text-center">
				      				<button type="submit" class="btn btn-primary" name="submit" value="submit">Konfirmasi</button>
				      			</div>
				      		</form>
				      	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
<?php include '../templates/footer.html.php' ?>