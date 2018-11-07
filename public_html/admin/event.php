<?php
	session_start();

	include_once '../../includes/constant.php';
	if ($_SESSION['hakAkses'] != HAK_AKSES_ADMIN) {
		header('location: /');
	}

	include '../../includes/function_database.php';
	$events = getAllEvent();

	include '../../templates/header.html.php';
?>
<title>Admin - Event</title>
</head>
<body>
	<?php include '../../templates/nav.html.php'; ?>
	<div class="container">
		<?php if(isset($_COOKIE['tambahEvent'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Penambahan Event Berhasil</strong><br>Anda berhasil menambahkan event baru.</div>
		<?php endif ?>
		<div class="row">
			<a href="/admin/tambah_event.php" class="btn btn-primary">Tambah Event</a>
		</div><br>
		<div class="row">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Nama Event</th>
						<th class="text-center">Tiket Reguler</th>
						<th class="text-center">Tiket Silver</th>
						<th class="text-center">Tiket Gold</th>
					</tr>
				</thead>
				<?php if(isset($events)): ?>
				<tbody>
					<?php $i=1; foreach($events as $event): ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td><a href="/admin/detail_event.php?id=<?= $event['id'] ?>"><?= $event[EVENT_NAMA] ?></a></td>
						<td class="text-center"><?= $event[EVENT_JUMLAH_REGULER] ?></td>
						<td class="text-center"><?= $event[EVENT_JUMLAH_SILVER] ?></td>
						<td class="text-center"><?= $event[EVENT_JUMLAH_GOLD] ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
				<?php endif ?>
			</table>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>