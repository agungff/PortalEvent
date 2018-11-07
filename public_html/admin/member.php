<?php
	session_start();

	include_once '../../includes/constant.php';
	if ($_SESSION['hakAkses'] != HAK_AKSES_ADMIN) {
		header('location: /');
	}

	include '../../includes/function_database.php';
	$members = getAllMember();

	include '../../templates/header.html.php';
?>
<title>Admin - Member</title>
</head>
<body>
	<?php include '../../templates/nav.html.php'; ?>
	<div class="container">
		<div class="row">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Nama Lengkap</th>
						<th class="text-center">Alamat Email</th>
						<th class="text-center">Nomor HP</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<?php if(isset($members)): ?>
				<tbody>
					<?php $i=1; foreach($members as $member): ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td><?= $member[MEMBER_NAMA_DEPAN].' '.$member[MEMBER_NAMA_BELAKANG] ?></td>
						<td class="text-center"><?= $member[MEMBER_EMAIL] ?></td>
						<td class="text-center"><?= $member[MEMBER_NOMOR_HP] ?></td>
						<td class="text-center">&nbsp;</td>
					</tr>
					<?php endforeach ?>
				</tbody>
				<?php endif ?>
			</table>
		</div>
	</div>
<?php include '../../templates/footer.html.php' ?>