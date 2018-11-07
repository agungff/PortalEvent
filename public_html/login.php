<?php
	session_start();

	if (isset($_SESSION['id'])) {
		header('location: /');
	}

	if (isset($_POST['submit'])) {
		$member = $_POST['member'];
		$member['email'] = strtolower(trim($member['email']));

		//validasi alamat email
		if (empty($member['email'])) {
			$error = 'Alamat email Anda masih kosong';
		} elseif (!filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
			$error = 'Alamat email Anda tidak valid';
		}

		//semua aman
		else {
			include __DIR__.'/../includes/function_database.php';
			include_once __DIR__.'/../includes/constant.php';

			$login = login($member['email'], $member['password']);

			if ($login === true) {
				setcookie('login', 1, time()+1);
				header('location: /');
			} elseif ($login === false) {
				$error = 'Email atau password salah';
				$danger = true;
			} else {
				$error = $login;
			}
		}
	}

	include '../templates/header.html.php';
?>
<title>Portal Event - Masuk</title>
</head>
<body>
	<?php include '../templates/nav.html.php'; ?>
	<div class="container">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<?php if(!empty($error)): ?>
				<div class="alert <?php echo isset($danger) ? 'alert-danger' : 'alert-warning' ?> alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?= $error ?>
				</div>
			<?php endif ?>
			<div class="panel-group">
				<div class="panel panel-primary">
					<div class="panel-heading text-center"><strong>FORM LOGIN</strong></div>
					<div class="panel-body">
						<form action="" method="post">
							<div class="form-group">
								<label for="email">Alamat Email</label>
								<input type="text" maxlength="100" id="email" class="form-control" name="member[email]" placeholder="Alamat Email">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" maxlength="100" id="password" class="form-control" name="member[password]" placeholder="Password">
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
							</div>
						</form>
					</div>
					<div class="panel-footer">Belum punya akun? <a href="/signup.php"><strong>Daftar</strong></a></div>
				</div>
			</div>
		</div>
	</div>
<?php include '../templates/footer.html.php' ?>