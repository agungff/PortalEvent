<?php
	session_start();

	if (isset($_SESSION['id'])) {
		header('location: /');
	}

	if (isset($_POST['submit'])) {
		$member = $_POST['member'];
		$member['namaDepan'] = ucfirst(strtolower(trim($member['namaDepan'])));
		$member['namaBelakang'] = ucfirst(strtolower(trim($member['namaBelakang'])));
		$member['nomorHp'] = trim($member['nomorHp']);
		$member['email'] = strtolower(trim($member['email']));
		$konfirmasiPassword = $_POST['konfirmasiPassword'];

		//validasi nama depan
		if (empty($member['namaDepan'])) {
			$error = 'Anda belum mengisi Nama Depan';
		} elseif (!preg_match('/^[a-zA-Z]*$/', $member['namaDepan'])) {
			$error = 'Nama Depan Anda tidak valid';
		}

		//validasi nama belakang
		elseif (!preg_match('/^[a-zA-Z]*$/', $member['namaBelakang'])) {
			$error = 'Nama Belakang Anda tidak valid';
		}

		//validasi nomor hp
		elseif (empty($member['nomorHp'])) {
			$error = 'Anda belum mengisi Nomor HP';
		} elseif (!preg_match('/^[0-9]*$/', $member['nomorHp'])) {
			$error = 'Nomor HP Anda tidak valid';
		}

		//validasi alamat email
		elseif (empty($member['email'])) {
			$error = 'Alamat email Anda masih kosong';
		} elseif (!filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
			$error = 'Alamat email Anda tidak valid';
		}

		//password
		elseif (empty($member['password'])) {
			$error = 'Anda belum mengisi password';
		} elseif (strlen($member['password']) < 8) {
			$error = 'Gunakan minimal 8 karakter password';
		} elseif ($member['password'] !== $konfirmasiPassword) {
			$error = 'Konfirmasi password Anda tidak sama';
		}

		//semua aman
		else {
			include __DIR__.'/../includes/function_database.php';
			include_once __DIR__.'/../includes/constant.php';

			if (checkMemberBy(MEMBER_EMAIL, $member['email'])) {
				$error = 'Alamat email <strong>'.$member['email'].'</strong> sudah digunakan oleh member lain';
			} else {
				$kode = md5(rand(10000, 99999).$member['email']);
				$member['password'] = password_hash($member['password'], PASSWORD_DEFAULT);

				insertMember($member['namaDepan'], $member['namaBelakang'], $member['nomorHp'], $member['email'], $member['password']);
				insertAktivasi($member['email'], $kode);

				$body = '<strong>Aktivasi Akun</strong><br>'
				.'klik link berikut untuk aktivasi akun anda sebagai member di Portal Event<br>'
				.'link : <a href="portal-event.com/activation.php?id='.$kode.'">aktivasi</a>';
				kirimEmail($member['email'], 'Pendaftaran Akun', $body);

				setcookie('registrasi', 1, time()+1);
				header('location: /');
			}
		}
	}

	include '../templates/header.html.php';
?>
<title>Portal Event - Pendaftaran</title>
</head>
<body>
	<?php include '../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<?php if(!empty($error)): ?>
					<div class="alert alert-warning alert-dismissible fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<?= $error ?>
					</div>
				<?php endif ?>
				<div class="panel-group">
					<div class="panel panel-primary">
						<div class="panel-heading text-center"><strong>FORM PENDAFTARAN MEMBER</strong></div>
						<div class="panel-body">
							<form action="" method="post">
								<div class="row">
									<div class="form-group col-md-6">
										<label for="namaDepan">Nama Depan</label>
										<input type="text" maxlength="20" id="namaDepan" class="form-control" name="member[namaDepan]" placeholder="Nama Depan" value="<?= $member['namaDepan'] ?? '' ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="namaBelakang">Nama Belakang</label>
										<input type="text" maxlength="20" id="namaBelakang" class="form-control" name="member[namaBelakang]" placeholder="Nama Belakang" value="<?= $member['namaBelakang'] ?? '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="hp">Nomor HP</label>
									<input type="text" maxlength="15" id="hp" class="form-control" name="member[nomorHp]" placeholder="Nomor HP" value="<?= $member['nomorHp'] ?? '' ?>">
								</div>
								<div class="form-group">
									<label for="email">Alamat Email</label>
									<input type="text" maxlength="100" id="email" class="form-control" name="member[email]" placeholder="Alamat Email" value="<?= $member['email'] ?? '' ?>">
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label for="password">Password</label>
										<input type="password" maxlength="100" id="password" class="form-control" name="member[password]" placeholder="Password" value="<?= $member['password'] ?? '' ?>">
									</div>
									<div class="form-group col-md-6">
										<label for="konfirmasiPassword">Konfirmasi Password</label>
										<input type="password" maxlength="100" id="konfirmasiPassword" class="form-control" name="konfirmasiPassword" placeholder="Konfirmasi Password">
									</div>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Daftar</button>
								</div>
							</form>
						</div>
						<div class="panel-footer">Sudah punya akun? <a href="/login.php"><strong>Masuk</strong></a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '../templates/footer.html.php' ?>