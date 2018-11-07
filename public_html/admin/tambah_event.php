<?php
	session_start();

	include_once '../../includes/constant.php';
	if ($_SESSION['hakAkses'] != HAK_AKSES_ADMIN) {
		header('location: /');
	}

	if (isset($_POST['submit'])) {
		$errors = array();
		$event = $_POST['event'];

		$event['nama'] = isset($event['nama']) ? trim($event['nama']) : '';
		$event['hargaReguler'] = isset($event['hargaReguler']) ? $event['hargaReguler'] : '';
		$event['jumlahReguler'] = isset($event['jumlahReguler']) ? $event['jumlahReguler'] : '';
		$event['hargaSilver'] = isset($event['hargaSilver']) ? $event['hargaSilver'] : '';
		$event['jumlahSilver'] = isset($event['jumlahSilver']) ? $event['jumlahSilver'] : '';
		$event['hargaGold'] = isset($event['hargaGold']) ? $event['hargaGold'] : '';
		$event['jumlahGold'] = isset($event['jumlahGold']) ? $event['jumlahGold'] : '';
		$event['deskripsi'] = isset($event['deskripsi']) ? trim($event['deskripsi']) : '';
		$event['lokasi'] = isset($event['lokasi']) ? trim($event['lokasi']) : '';

		// validasi nama event
		if (empty($event['nama'])) {
			$errors[] = '<strong>Nama Event</strong> belum ditentukan';
		}

		// validasi jumlah tiket dan harga
		if ((empty($event['jumlahReguler']) && empty($event['jumlahSilver']) && empty($event['jumlahGold'])) || ($event['jumlahReguler']==0 && $event['jumlahSilver']==0 && $event['jumlahGold']==0)) {
			$event['jumlahReguler'] = '';
			$event['jumlahSilver'] = '';
			$event['jumlahGold'] = '';
			$errors[] = '<strong>Jumlah Tiket</strong> belum ditentukan';
		} else {
			if (empty($event['jumlahReguler']) || $event['jumlahReguler']==0) {
				$event['jumlahReguler'] = '';
				$event['hargaReguler'] = '';
			} else {
				if ($event['jumlahReguler'] < 0) {
					$errors[] = 'Jumlah tiket harus <strong>bernilai positif</strong>';
				} else {
					if (empty($event['hargaReguler']) || $event['hargaReguler']==0) {
						$errors[] = '<strong>Harga Tiket Reguler</strong> belum ditentukan';
					} else {
						if ($event['hargaReguler'] < 0) {
							$errors[] = 'Harga Tiket Reguler harus <strong>bernilai positif</strong>';
						}
					}
				}
			}

			if (empty($event['jumlahSilver']) || $event['jumlahSilver']==0) {
				$event['jumlahSilver'] = '';
				$event['hargaSilver'] = '';
			} else {
				if ($event['jumlahSilver'] < 0) {
					$errors[] = 'Jumlah tiket harus <strong>bernilai positif</strong>';
				} else {
					if (empty($event['hargaSilver']) || $event['hargaSilver']==0) {
						$errors[] = '<strong>Harga Tiket Silver</strong> belum ditentukan';
					} else {
						if ($event['hargaSilver'] < 0) {
							$errors[] = 'Harga Tiket Silver harus <strong>bernilai positif</strong>';
						}
					}
				}
			}

			if (empty($event['jumlahGold']) || $event['jumlahGold']==0) {
				$event['jumlahGold'] = '';
				$event['hargaGold'] = '';
			} else {
				if ($event['jumlahGold'] < 0) {
					$errors[] = 'Jumlah tiket harus <strong>bernilai positif</strong>';
				} else {
					if (empty($event['hargaGold']) || $event['hargaGold']==0) {
						$errors[] = '<strong>Harga Tiket Gold</strong> belum ditentukan';
					} else {
						if ($event['hargaGold'] < 0) {
							$errors[] = 'Harga Tiket Gold harus <strong>bernilai positif</strong>';
						}
					}
				}
			}
		}

		// validasi lokasi
		if (empty($event['lokasi'])) {
			$errors[] = '<strong>Lokasi Event</strong> belum ditentukan';
		}

		// validasi tanggal dan jam mulai
		if (empty($_POST['tanggalMulai'])) {
			$errors[] = '<strong>Tanggal Mulai Event</strong> belum ditentukan';
		} else {
			$event['waktuMulai'] = $_POST['tanggalMulai'];
			
			if (empty($_POST['jamMulai'])) {
				$errors[] = '<strong>Jam Mulai Event</strong> belum ditentukan';
			} else {
				$event['waktuMulai'] .= ' '.$_POST['jamMulai'];

				if ((time()+(60*60)) > strtotime($event['waktuMulai'])) {
					$errors[] = 'Event harus dimulai <strong>minimal 1 jam</strong> dari sekarang';
				}
			}
		}

		// validasi tanggal dan jam selesai
		if (empty($_POST['tanggalSelesai'])) {
			$errors[] = '<strong>Tanggal Selesai Event</strong> belum ditentukan';
		} else {
			$event['waktuSelesai'] = $_POST['tanggalSelesai'];

			if (empty($_POST['jamSelesai'])) {
				$errors[] = '<strong>Jam Selesai Event</strong> belum ditentukan';
			} else {
				$event['waktuSelesai'] .= ' '.$_POST['jamSelesai'];

				if (strtotime($event['waktuMulai'])+(60*30) > strtotime($event['waktuSelesai'])) {
					$errors[] = '<strong>Waktu Selesai Event</strong> minimal 	30 menit dari <strong>Waktu Mulai Event</strong>';
				}
			}
		}

		// validasi gambar
		if (empty($_FILES['gambar']) || empty($_FILES['gambar']['name'])) {
			$errors[] = '<strong>Gambar Event</strong> belum ditentukan';
		} else {
			$target_dir = '../images/';
			$target_file = $target_dir . basename($_FILES['gambar']['name']);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$check = getimagesize($_FILES['gambar']['tmp_name']);

		    if($check !== false) {
		        $uploadOk = 1;
		    } else {
		        $uploadOk = 0;
		    }

		    if ($_FILES["gambar"]["size"] > 500000) {
		    	$errors[] = 'Maksimal ukuran gambar <strong>500 KB</strong>';
		        $uploadOk = 0;
		    }

		    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		    && $imageFileType != "gif" ) {
		    	$errors[] = 'Gambar harus bertipe <strong>JPG, JPEG, PNG</strong> atau <strong>GIF</strong>';
		        $uploadOk = 0;
		    }
		}

		// semua aman
		if (!$errors) {
		    if ($uploadOk == 1) {
	    	    $temp = explode(".", $_FILES["gambar"]["name"]);
	    		$namaGambar = round(microtime(true)) . '.' . end($temp);

	            include __DIR__.'/../../includes/function_database.php';
	            include_once __DIR__.'/../../includes/constant.php';

	            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_dir.$namaGambar);
            	insertEvent($event['nama'], $event['deskripsi'], $event['lokasi'], $event['jumlahReguler'], $event['hargaReguler'], $event['jumlahSilver'], $event['hargaSilver'], $event['jumlahGold'], $event['hargaGold'], $event['waktuMulai'], $event['waktuSelesai'], $namaGambar);

            	setcookie('tambahEvent', 1, time()+1);
            	header('location: /admin/event.php');
		    }
		}
	}

	include '../../templates/header.html.php';
?>
<title>Admin - Tambah Event</title>
</head>
<body>
	<?php include '../../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<?php if(!empty($errors)): ?>
					<div class="alert alert-warning alert-dismissible fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?= $errors[0] ?>
					</div>
				<?php endif ?>
				<div class="panel-group">
					<div class="panel panel-primary">
						<div class="panel-heading text-center"><strong>FORM TAMBAH EVENT</strong></div>
						<div class="panel-body">
							<form action="" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="nama">Nama Event</label>
									<input type="text" maxlength="100" id="nama" class="form-control" name="event[nama]" placeholder="Nama Event" value="<?= $event['nama'] ?? '' ?>">
								</div>
								<label for="jumlahTiket">Jumlah tiket dan harga yang ditawarkan</label>
								<div class="row" id="jumlahTiket">
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Jumlah Tiket Reguler" name="event[jumlahReguler]" value="<?= $event['jumlahReguler'] ?? '' ?>">
									</div>
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Jumlah Tiket Silver" name="event[jumlahSilver]" value="<?= $event['jumlahSilver'] ?? '' ?>">
									</div>
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Jumlah Tiket Gold" name="event[jumlahGold]" value="<?= $event['jumlahGold'] ?? '' ?>">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Harga Tiket Reguler" name="event[hargaReguler]" value="<?= $event['hargaReguler'] ?? '' ?>">
									</div>
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Harga Tiket Silver" name="event[hargaSilver]" value="<?= $event['hargaSilver'] ?? '' ?>">
									</div>
									<div class="form-group col-md-4">
										<input type="number" class="form-control" placeholder="Harga Tiket Gold" name="event[hargaGold]" value="<?= $event['hargaGold'] ?? '' ?>">
									</div>
								</div>
						  	  	<div class="form-group">
						  		    <label for="deskripsi">Deskripsi Event</label>
						  		    <textarea class="form-control" id="deskripsi" name="event[deskripsi]" placeholder="Deskripsi Event" rows="5"><?= $event['deskripsi'] ?? '' ?></textarea>
						  	  	</div>
					  	  	  	<div class="form-group">
					  	  		    <label for="lokasi">Lokasi Event</label>
					  	  		    <textarea class="form-control" maxlength="255" id="lokasi" name="event[lokasi]" placeholder="Lokasi Event" rows="2"><?= $event['lokasi'] ?? '' ?></textarea>
					  	  	  	</div>
					  	  	  	<div class="row">
									<div class="form-group col-md-6">
					  	  		    	<label for="tanggalMulai">Tanggal Mulai Event</label>
										<input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" value="<?= substr($event['waktuMulai'], 0, 10) ?? '' ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="jamMulai">Jam Mulai Event</label>
										<input type="time" class="form-control" id="jamMulai"  name="jamMulai" value="<?= substr($event['waktuMulai'], 11) ?? '' ?>">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
					  	  		    	<label for="tanggalSelesai">Tanggal Selesai Event</label>
										<input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai" value="<?= substr($event['waktuSelesai'], 0, 10) ?? '' ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="jamSelesai">Jam Selesai Event</label>
										<input type="time" class="form-control" id="jamSelesai"  name="jamSelesai" value="<?= substr($event['waktuSelesai'], 11) ?? '' ?>">
									</div>
								</div>
								<div class="form-group">
					  	  		    <label for="gambar">Gambar Event</label>
						  	  		<input type="file" name="gambar" id="gambar">
					  	  	  	</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Simpan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>