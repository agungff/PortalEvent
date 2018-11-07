<?php
	session_start();

	include_once '../../includes/constant.php';
	if ($_SESSION['hakAkses'] != HAK_AKSES_ADMIN) {
		header('location: /');
	}

	if (!(isset($_GET['id']) && !empty($_GET['id']))) {
		header('location: /admin/event.php');
	} else {
		include '../../includes/function_database.php';;

		$bool = checkEventById($_GET['id']);

		if ($bool) {
			$event = getEventById($_GET['id']);

			if ($event['jumlahReguler']>0) {
				include '../../includes/mysqli_connect.php';

				try {
					$stmt = $mysqli->prepare('SELECT sum(jumlahReguler) as jumlah FROM tb_transaksi WHERE idEvent = ? AND jumlahReguler>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$pendaftarReguler = $hasil['jumlah'];

					$stmt = $mysqli->prepare('SELECT sum(jumlahReguler) as jumlah FROM tb_transaksi WHERE idEvent = ? AND terbayar = tagihan AND jumlahReguler>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$sudahBayarReguler = $hasil['jumlah'];

					$belumBayarReguler = $pendaftarReguler-$sudahBayarReguler;
				} catch (Exception $e) {
					error_log($e->getMessage());
					exit('Gagal terhubung dengan database');
				}
			}

			if ($event['jumlahSilver']>0) {
				include '../../includes/mysqli_connect.php';

				try {
					$stmt = $mysqli->prepare('SELECT sum(jumlahSilver) as jumlah FROM tb_transaksi WHERE idEvent = ? AND jumlahSilver>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$pendaftarSilver = $hasil['jumlah'];

					$stmt = $mysqli->prepare('SELECT sum(jumlahSilver) as jumlah FROM tb_transaksi WHERE idEvent = ? AND terbayar = tagihan AND jumlahSilver>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$sudahBayarSilver = $hasil['jumlah'];

					$belumBayarSilver = $pendaftarSilver - $sudahBayarSilver;
				} catch (Exception $e) {
					error_log($e->getMessage());
					exit('Gagal terhubung dengan database');
				}
			}

			if ($event['jumlahGold']>0) {
				include '../../includes/mysqli_connect.php';

				try {
					$stmt = $mysqli->prepare('SELECT sum(jumlahGold) as jumlah FROM tb_transaksi WHERE idEvent = ? AND jumlahGold>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$pendaftarGold = $hasil['jumlah'];

					$stmt = $mysqli->prepare('SELECT sum(jumlahGold) as jumlah FROM tb_transaksi WHERE idEvent = ? AND terbayar = tagihan AND jumlahGold>0');
					$stmt->bind_param('i', $event['id']);
					$stmt->execute();
					$hasil = $stmt->get_result()->fetch_assoc();
					$stmt->close();

					$sudahBayarGold = $hasil['jumlah'];

					$belumBayarGold = $pendaftarGold - $sudahBayarGold;
				} catch (Exception $e) {
					error_log($e->getMessage());
					exit('Gagal terhubung dengan database');
				}
			}

			include '../../includes/mysqli_connect.php';

			try {
				$stmt = $mysqli->prepare('SELECT sum(tagihan) as jumlah FROM tb_transaksi WHERE idEvent = ?');
				$stmt->bind_param('i', $event['id']);
				$stmt->execute();
				$hasil = $stmt->get_result()->fetch_assoc();
				$stmt->close();

				$tagihan = $hasil['jumlah'];

				$stmt = $mysqli->prepare('SELECT sum(terbayar) as jumlah FROM tb_transaksi WHERE idEvent = ?');
				$stmt->bind_param('i', $event['id']);
				$stmt->execute();
				$hasil = $stmt->get_result()->fetch_assoc();
				$stmt->close();

				$terbayar = $hasil['jumlah'];

				$uangMasuk = $terbayar;
				$uangBelumMasuk = $tagihan - $terbayar;
			} catch (Exception $e) {
				error_log($e->getMessage());
				exit('Gagal terhubung dengan database');
			}
		} else {
			header('location: /admin/event.php');
		}
	}

	include '../../templates/header.html.php';
?>
<title>Detail Event</title>
</head>
<body>
	<?php include '../../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel-group">
					<div class="panel panel-primary">
						<div class="panel-heading text-center"><strong>DETAIL EVENT</strong></div>
						<div class="panel-body">
							<table class="table table-striped">
								<tr>
									<td colspan="3"><img src="/images/<?= $event[EVENT_GAMBAR] ?>" class="img-responsive" style="width:100%" alt="Image"></td>
								</tr>
								<tr>
									<td><strong>Nama Event</strong></td>
									<td>:</td>
									<td><?= $event['nama'] ?></td>
								</tr>
								<tr>
									<td><strong>Deskripsi</strong></td>
									<td>:</td>
									<td><?= $event['deskripsi'] ?></td>
								</tr>
								<tr>
									<td><strong>Lokasi</strong></td>
									<td>:</td>
									<td><?= $event['lokasi'] ?></td>
								</tr>
								<tr>
									<td><strong>Waktu Mulai</strong></td>
									<td>:</td>
									<td><?= $event['waktuMulai'] ?></td>
								</tr>
								<tr>
									<td><strong>Waktu Selesai</strong></td>
									<td>:</td>
									<td><?= $event['waktuSelesai'] ?></td>
								</tr>
								<?php if($event['jumlahReguler']>0): ?>
								<tr>
									<td colspan="3" class="text-center"><strong>Tiket Reguler</strong><br><br>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Pendaftar</th>
													<th class="text-center">Sudah Bayar</th>
													<th class="text-center">Belum Bayar</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?= $event['jumlahReguler'] ?></td>
													<td><?= $pendaftarReguler ?? 0 ?></td>
													<td><?= $sudahBayarReguler ?? 0 ?></td>
													<td><?= $belumBayarReguler ?? 0 ?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<?php endif ?>
								<?php if($event['jumlahSilver']>0): ?>
								<tr>
									<td colspan="3" class="text-center"><strong>Tiket Silver</strong><br><br>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Pendaftar</th>
													<th class="text-center">Sudah Bayar</th>
													<th class="text-center">Belum Bayar</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?= $event['jumlahSilver'] ?></td>
													<td><?= $pendaftarSilver ?? 0 ?></td>
													<td><?= $sudahBayarSilver ?? 0 ?></td>
													<td><?= $belumBayarSilver ?? 0 ?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<?php endif ?>
								<?php if($event['jumlahGold']>0): ?>
								<tr>
									<td colspan="3" class="text-center"><strong>Tiket Gold</strong><br><br>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Pendaftar</th>
													<th class="text-center">Sudah Bayar</th>
													<th class="text-center">Belum Bayar</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?= $event['jumlahGold'] ?></td>
													<td><?= $pendaftarGold ?? 0 ?></td>
													<td><?= $sudahBayarGold ?? 0 ?></td>
													<td><?= $belumBayarGold ?? 0 ?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<?php endif ?>
								<tr>
									<td><strong>Uang Masuk</strong></td>
									<td>:</td>
									<td><strong>Rp <?= $uangMasuk ?? 0 ?>,00</strong></td>
								</tr>
								<tr>
									<td><strong>Uang Belum Masuk</strong></td>
									<td>:</td>
									<td><strong>Rp <?= $uangBelumMasuk ?? 0 ?>,00</strong></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>