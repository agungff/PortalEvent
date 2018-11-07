<?php
	session_start();

	include_once '../../includes/constant.php';
	if ($_SESSION['hakAkses'] != HAK_AKSES_MEMBER) {
		header('location: /');
	}

	include '../../includes/mysqli_connect.php';

	try {
		$stmt = $mysqli->prepare('SELECT 
			tb_transaksi.id, 
			tb_event.nama, 
			tb_transaksi.jumlahReguler, 
			tb_transaksi.jumlahSilver, 
			tb_transaksi.jumlahGold, 
			tb_transaksi.tagihan, 
			tb_transaksi.terbayar  
			FROM tb_transaksi, tb_event 
			WHERE tb_transaksi.idMember = ? AND tb_transaksi.idEvent = tb_event.id');
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();
		$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt->close();
	} catch (Exception $e) {
		error_log($e->getMessage());
		exit('Gagal terhubung dengan database');
	}

	if (isset($_POST['submit'])) {
		if (isset($_POST['buktiBayar'])) {
			$buktiBayar = $_POST['buktiBayar'];
			var_dump($buktiBayar);
		} else {
			$error = 'Tidak ada bukti transfer yang diupload';
		}
	}

	include '../../templates/header.html.php';
?>
<title>Member - Event</title>
</head>
<body>
	<?php include '../../templates/nav.html.php';?>
	<div class="container">
		<?php if(isset($error)): ?>
		<div class="row">
			<div class="alert alert-warning alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $error ?></div>
		</div>
		<?php endif ?>
		<div class="row">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th rowspan="2" class="text-center">No</th>
						<th rowspan="2" class="text-center">Nama Event</th>
						<th colspan="3" class="text-center">Jenis Tiket</th>
						<th rowspan="2" class="text-center">Tagihan</th>
						<th rowspan="2" class="text-center">Status Bayar</th>
					</tr>
					<tr>
						<th class="text-center">Reguler</th>
						<th class="text-center">Silver</th>
						<th class="text-center">Gold</th>
					</tr>
				</thead>
				<?php if(isset($rows)): ?>
				<tbody>
					<?php $i=1; foreach($rows as $row): ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td><?php if($row['terbayar']==0): ?><a href="/member/upload_bukti_transfer.php?id=<?= $row['id'] ?>"><?= $row['nama'] ?></a><?php else: ?><?= $row['nama'] ?><?php endif ?></td>
						<td class="text-center"><?= $row['jumlahReguler'] ?></td>
						<td class="text-center"><?= $row['jumlahSilver'] ?></td>
						<td class="text-center"><?= $row['jumlahGold'] ?></td>
						<td class="text-center"><?= $row['tagihan'] ?></td>
						<td class="text-center">
							<?php
								if($row['tagihan'] == $row['terbayar']) echo 'Lunas';
								elseif($row['terbayar'] == 0) echo 'Belum bayar';
								else $row['terbayar'];
							?>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
				<?php endif ?>
			</table>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>