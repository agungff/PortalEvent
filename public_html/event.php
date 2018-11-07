<?php
	session_start();

	if (isset($_GET['id']) && !empty($_GET['id'])) {
		include '../includes/function_database.php';
		include '../includes/constant.php';

		$id = $_GET['id'];
		$event = getEventById($id);

		if (!isset($event)) {
			header('location: /');
		}

		if (isset($_POST['submit'])) {
			$jumlahReguler = isset($_POST['jumlahReguler']) ? $_POST['jumlahReguler'] : 0;
			$jumlahSilver = isset($_POST['jumlahSilver']) ? $_POST['jumlahSilver'] : 0;
			$jumlahGold = isset($_POST['jumlahGold']) ? $_POST['jumlahGold'] : 0;

			if ($jumlahReguler>0 || $jumlahSilver>0 || $jumlahGold>0) {
				if ($jumlahReguler<0) {
					$error = 'Jumlah tiket reguler Anda minus';
				} elseif ($jumlahSilver<0) {
					$error = 'Jumlah tiket silver Anda minus';
				} elseif ($jumlahGold<0) {
					$error = 'Jumlah tiket gold Anda minus';
				} else {
					setcookie('eventId', $event[EVENT_ID], time()+60*5);
					setcookie('jumlahReguler', $jumlahReguler, time()+60*5);
					setcookie('jumlahSilver', $jumlahSilver, time()+60*5);
					setcookie('jumlahGold', $jumlahGold, time()+60*5);
					header('location: /pesan.php');
				}
			} else {
				$error = 'Anda belum memilih tiket';
			}
		}
	}

	include '../templates/header.html.php';
?>
<title>Detail Event</title>
</head>
<body>
	<?php include '../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<?php if(isset($error)): ?>
					<div class="alert alert-warning alert-dismissible fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?= $error ?>
					</div>
				<?php endif ?>
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
				      		<strong>Harga Tiket :</strong><br>
				      		<ul>
				      			<?php if($event['hargaReguler'] != 0): ?>
				      				<li><strong>Reguler : </strong> Rp <?= $event[EVENT_HARGA_REGULER].',00' ?></li>
				      			<?php endif ?>
				      			<?php if($event['hargaSilver'] != 0): ?>
				      				<li><strong>Silver : </strong> Rp <?= $event[EVENT_HARGA_SILVER].',00' ?></li>
				      			<?php endif ?>
				      			<?php if($event['hargaGold'] != 0): ?>
				      				<li><strong>Gold : </strong> Rp <?= $event[EVENT_HARGA_GOLD].',00' ?></li>
				      			<?php endif ?>
				      		</ul>
				      		<?php if(isset($_SESSION['id'])): ?>
				      		<?php if($_SESSION['hakAkses'] == HAK_AKSES_MEMBER): ?>
				      			<strong>Pembelian :</strong><br>
					      		<form action="" method="post" class="form-inline">
					      			<?php if($event['hargaReguler'] != 0): ?>
						      			<div class="form-group">
						      			    <input type="number" class="form-control" name="jumlahReguler" placeholder="Jumlah Tiket Reguler" max="10" value="<?= $jumlahReguler ?? '' ?>">
						      			</div>
					      			<?php endif ?>
					      			<?php if($event['hargaSilver'] != 0): ?>
						      			<div class="form-group">
						      			    <input type="number" class="form-control" name="jumlahSilver" placeholder="Jumlah Tiket Silver" max="10" value="<?= $jumlahSilver ?? '' ?>">
						      			</div>
					      			<?php endif ?>
					      			<?php if($event['hargaGold'] != 0): ?>
						      			<div class="form-group">
						      			    <input type="number" class="form-control" name="jumlahGold" placeholder="Jumlah Tiket Gold" max="10" value="<?= $jumlahGold ?? '' ?>">
						      			</div>
					      			<?php endif ?>
					      			<button type="submit" class="btn btn-primary" name="submit" value="submit">Pesan</button>
					      		</form>
				      		<?php endif ?>
				      		<?php endif ?>
				      	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
<?php include '../templates/footer.html.php' ?>