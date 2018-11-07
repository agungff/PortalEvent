<?php
	session_start();

	if ($_SESSION['hakAkses'] != 3) {
		header('location: /');
	}

	if (!(isset($_GET['id']) && !empty($_GET['id']))) {
		header('location: /');
	} else {
		include '../../includes/function_database.php';
		include '../../includes/constant.php';

		$bool = checkTransaksiBy($_GET['id'], $_SESSION['id']);

		if ($bool) {
			$transaksi = getTransaksiById($_GET['id']);
			$event = getEventById($transaksi['idEvent']);

			if (isset($_POST['submit'])) {
				if (empty($_FILES['foto']) || empty($_FILES['foto']['name'])) {
					$error = '<strong>Bukti Transfer</strong> belum ditentukan';
				} else {
					$target_dir = '../images/bukti/';
					$target_file = $target_dir . basename($_FILES['foto']['name']);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

					$check = getimagesize($_FILES['foto']['tmp_name']);

				    if($check !== false) {
				        $uploadOk = 1;
				    } else {
				        $uploadOk = 0;
				    }

				    if ($_FILES["foto"]["size"] > 1000000) {
				    	$error = 'Maksimal ukuran gambar <strong>1 MB</strong>';
				        $uploadOk = 0;
				    }

				    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				    && $imageFileType != "gif" ) {
				    	$error = 'Foto harus bertipe <strong>JPG, JPEG, PNG</strong> atau <strong>GIF</strong>';
				        $uploadOk = 0;
				    }

				    if (!isset($error)) {
					    if ($uploadOk == 1) {
				    	    $temp = explode(".", $_FILES["foto"]["name"]);
				    		$namaFoto = round(microtime(true)) . '.' . end($temp);

				            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir.$namaFoto);

				            if (uploadBuktiTransfer($transaksi['id'], $transaksi['tagihan'])) {
				            	$body = 'Terima kasih telah melakukan pelunasan pembayaran tiket : <strong>'.$event['nama'].'</strong>, seharga <strong>Rp '.$transaksi['tagihan'].',00</strong>.';

				            	kirimEmail($_SESSION['email'], 'Pelunasan Pembayaran', $body);

					        	setcookie('uploadBukti', 1, time()+1);
					        	header('location: /member/event.php');
				            } else {
				            	$error = 'Upload bukti transfer gagal';
				            }
					    }
					}
				}
			}
		} else {
			header('location: /');
		}
	}

	include '../../templates/header.html.php';
?>
<title>Upload Bukti Transfer</title>
</head>
<body>
	<?php include '../../templates/nav.html.php'; ?>
	<div class="container">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<?php if(!empty($error)): ?>
				<div class="alert alert-warning alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?= $error ?>
				</div>
			<?php endif ?>
			<div class="panel-group">
				<div class="panel panel-primary">
					<div class="panel-heading text-center"><strong>FORM UPLOAD BUKTI TRANSFER</strong></div>
					<div class="panel-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<strong>Nama Event : </strong><br>
								<?= $event['nama'] ?><br><br>
								<strong>Total Tagihan : </strong><br>
								<?= 'Rp '.$transaksi['tagihan'].',00' ?>
							</div>
							<div class="form-group">
				  	  		    <label for="foto">Bukti Transfer</label>
					  	  		<input type="file" name="foto" id="foto">
				  	  	  	</div>
							<div class="text-center">
								<button type="submit" class="btn btn-primary" name="submit" value="submit">Upload</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>