<?php
	session_start();

	include '../includes/function_database.php';
	include_once '../includes/constant.php';
	$totalEvent = getTotalEvent();
	$events = getAllEvent();

	include '../templates/header.html.php';
?>
<title>Portal Event</title>
</head>
<body>
	<?php include '../templates/nav.html.php'; ?>
	<div class="container">
		<div class="container-fluid">    
		<?php if(isset($_COOKIE['registrasi'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Registrasi Berhasil</strong><br>Anda sudah terdaftar di Portal Event. Silahkan cek email Anda untuk melakukan konfirmasi agar dapat menggunakan layanan kami.</div>
		<?php elseif(isset($_COOKIE['login'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Selamat datang <strong><?= $_SESSION['nama'] ?? '' ?></strong>.</div>
		<?php elseif(isset($_COOKIE['logout'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Logout berhasil</strong><br>Anda berhasil keluar.</div>
		<?php elseif(isset($_COOKIE['aktivasi'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Aktivasi berhasil</strong><br>Silahkan masuk untuk menggunakan layanan kami.</div>
		<?php elseif(isset($_COOKIE['pesan'])): ?>
			<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Pemesanan berhasil</strong><br>Anda berhasil melakukan pemesanan tiket. Detail pemesanan kami kirimkan ke email Anda.</div>
		<?php endif ?>
		<?php $i=0; foreach($events as $event): ?>
		<?php if($i%3==0): ?>
		  	<div class="row">
		  		<?php endif ?>
		    	<div class="col-sm-4">
		      		<div class="panel panel-primary">
		        		<div class="panel-heading text-center"><strong><?= $event[EVENT_NAMA] ?></strong></div>
		        		<div class="panel-body text-center"><img src="/images/<?= $event[EVENT_GAMBAR] ?>" class="img-responsive" style="width:100%" alt="Image"><br><?= htmlspecialchars($event[EVENT_LOKASI], ENT_QUOTES, 'UTF-8') ?></div>
		        		<div class="panel-footer text-center"><a href="/event.php?id=<?= $event[EVENT_ID] ?>">Detail</a></div>
		      		</div>
		    	</div>
		    	<?php if($i%3==2): ?>
		 	</div>
		 	<?php endif; $i++; ?>
		 	<?php endforeach ?>
		</div>
	</div>
<?php include '../templates/footer.html.php' ?>