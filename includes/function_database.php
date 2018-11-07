<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	// MEMBER
	function login($username, $password) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.MEMBER_TABLE.'` WHERE `'.MEMBER_EMAIL.'` = ? LIMIT 1');
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$hasil = $stmt->get_result();
			$stmt->close();

			if ($hasil->num_rows == 0) {
				return false;
			} else {
				$row = $hasil->fetch_assoc();

				if (password_verify($password, $row[MEMBER_PASSWORD])) {
					if ($row[MEMBER_STATUS] == 0) {
						return 'Akun Anda belum aktif. Silahkan aktifkan akun melalui link yang kami kirimkan ke alamat email Anda.';
					} else {
						session_regenerate_id();
						$_SESSION['id'] = $row[MEMBER_ID];
						$_SESSION['email'] = $row[MEMBER_EMAIL];
						$_SESSION['nama'] = trim($row[MEMBER_NAMA_DEPAN].' '.$row[MEMBER_NAMA_BELAKANG]);
						$_SESSION['password'] = $row[MEMBER_PASSWORD];
						$_SESSION['hakAkses'] = $row[MEMBER_HAK_AKSES];

						return true;
					}
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data ke database');
		}
	}

	function insertMember($namaDepan, $namaBelakang, $nomorHp, $email, $password) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('INSERT INTO `'.MEMBER_TABLE.'` (`'.MEMBER_NAMA_DEPAN.'`, `'.MEMBER_NAMA_BELAKANG.'`, `'.MEMBER_NOMOR_HP.'`, `'.MEMBER_EMAIL.'`, `'.MEMBER_PASSWORD.'`) VALUES (?, ?, ?, ?, ?)');
			$stmt->bind_param('sssss', $namaDepan, $namaBelakang, $nomorHp, $email, $password);
			$stmt->execute();
			$stmt->close();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data ke database');
		}
	}

	function insertAktivasi($email, $kode) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('INSERT INTO `'.AKTIVASI_TABLE.'` (`'.AKTIVASI_EMAIL.'`, `'.AKTIVASI_KODE.'`) VALUES (?, ?)');
			$stmt->bind_param('ss', $email, $kode);
			$stmt->execute();
			$stmt->close();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data ke database');
		}
	}

	function aktivasi($kode) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT `'.AKTIVASI_EMAIL.'` FROM `'.AKTIVASI_TABLE.'` WHERE `'.AKTIVASI_KODE.'` = ? LIMIT 1');
			$stmt->bind_param('s', $kode);
			$stmt->execute();
			$hasil = $stmt->get_result();

			if ($hasil->num_rows > 0) {
				$row = $hasil->fetch_assoc();
				$email = $row[AKTIVASI_EMAIL];

				$stmt = $mysqli->prepare('UPDATE `'.MEMBER_TABLE.'` SET `'.MEMBER_STATUS.'` = ? WHERE `'.MEMBER_EMAIL.'` = ?');

				$stmt->bind_param('is', $i = 1, $email);
				$stmt->execute();
				$hasil = $stmt->affected_rows;

				if ($hasil > 0) {
					$stmt = $mysqli->prepare('DELETE FROM `'.AKTIVASI_TABLE.'` WHERE `'.AKTIVASI_KODE.'` = ?');
					$stmt->bind_param('s', $kode);
					$stmt->execute();
					$stmt->close();

					return $email;
				}
			}

			$stmt->close();
			return false;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal aktivasi data di database');
		}
	}

	function checkMemberBy($column, $value) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT `'.MEMBER_ID.'` FROM `'.MEMBER_TABLE.'` WHERE `'.$column.'` = ? LIMIT 1');
			$stmt->bind_param('s', $value);
			$stmt->execute();
			$hasil = $stmt->get_result();
			$stmt->close();

			return $hasil->num_rows ? true : false;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal terhubung dengan database');
		}
	}

	function checkEventById($id) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.EVENT_TABLE.'` WHERE `'.EVENT_ID.'` = ? LIMIT 1');
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$hasil = $stmt->get_result();
			$stmt->close();

			return $hasil->num_rows ? true : false;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal terhubung dengan database');
		}
	}

	function checkTransaksiBy($id, $idMember) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.TRANSAKSI_TABLE.'` WHERE `'.TRANSAKSI_ID.'` = ? AND `'.TRANSAKSI_ID_MEMBER.'` = ? LIMIT 1');
			$stmt->bind_param('ii', $id, $idMember);
			$stmt->execute();
			$hasil = $stmt->get_result();
			$stmt->close();

			return $hasil->num_rows ? true : false;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal terhubung dengan database');
		}
	}

	// ADMIN
	function kirimEmail($email, $subject = '', $body = '') {
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';

		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    $mail->SMTPDebug = 0 ;	// 0 tanpa pesan, 1 pesan sisi client, 2 pesan sisi client & server
		    $mail->isSMTP();        // Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';		// Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;             // Enable SMTP authentication
		    $mail->Username = 'dbelakangcoc@gmail.com';		// SMTP username
		    $mail->Password = 'dbcoc@gmail';    // SMTP password
		    $mail->SMTPSecure = 'tls';          // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                  // TCP port to connect to

		    //Recipients
		    $mail->setFrom('dbelakangcoc@gmail.com', 'Portal Event');
		    // $mail->addAddress($email, $nama);     // Add a recipient
		    $mail->addAddress($email);      	     // Name is optional
		    $mail->addReplyTo('dbelakangcoc@gmail.com', 'Portal Event');
		    // $mail->addCC('cc@example.com');
		    // $mail->addBCC('bcc@example.com');

		    //Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;
		    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		} catch (Exception $e) {
		    error_log($mail->ErrorInfo);
		}		
	}

	function getJumlahEvent() {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT count(`'.EVENT_ID.'`) FROM `'.MEMBER_TABLE.'`');
			$stmt->execute();
			$hasil = $stmt->get_result();
			$stmt->close();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal terhubung dengan database');
		}
	}

	function insertEvent($nama, $deskripsi, $lokasi, $jumlahReguler, $hargaReguler, $jumlahSilver, $hargaSilver, $jumlahGold, $hargaGold, $waktuMulai, $waktuSelesai, $gambar) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('INSERT INTO `'.EVENT_TABLE.'` (`'.EVENT_NAMA.'`, `'.EVENT_DESKRIPSI.'`, `'.EVENT_LOKASI.'`, `'.EVENT_JUMLAH_REGULER.'`, `'.EVENT_HARGA_REGULER.'`, `'.EVENT_JUMLAH_SILVER.'`, `'.EVENT_HARGA_SILVER.'`, `'.EVENT_JUMLAH_GOLD.'`, `'.EVENT_HARGA_GOLD.'`, `'.EVENT_WAKTU_MULAI.'`, `'.EVENT_WAKTU_SELESAI.'`, `'.EVENT_GAMBAR.'`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->bind_param('sssiiiiiisss', $nama, $deskripsi, $lokasi, $jumlahReguler, $hargaReguler, $jumlahSilver, $hargaSilver, $jumlahGold, $hargaGold, $waktuMulai, $waktuSelesai, $gambar);
			$stmt->execute();
			$stmt->close();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data event ke database');
		}
	}

	function getTotalEvent() {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT COUNT(*) AS jumlahEvent FROM `'.EVENT_TABLE.'`');
			$stmt->execute();
			$hasil = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			return $hasil['jumlahEvent'];
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal mengambil data event dari database');
		}
	}

	function getAllEvent() {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.EVENT_TABLE.'`');
			$stmt->execute();
			$hasil = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();

			return $hasil;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal mengambil data event dari database');
		}
	}

	function getAllMember() {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.MEMBER_TABLE.'` WHERE `'.MEMBER_HAK_AKSES.'` = ?');
			$hakAkses = HAK_AKSES_MEMBER;
			$stmt->bind_param('i', $hakAkses);
			$stmt->execute();
			$hasil = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			$stmt->close();

			return $hasil;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal mengambil data member dari database');
		}
	}

	function getEventById($id) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.EVENT_TABLE.'` WHERE `'.EVENT_ID.'` = ?');
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$hasil = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			return $hasil;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data event ke database');
		}
	}

	function tambahPesanan($kode, $memberId, $eventId, $jumlahReguler, $jumlahSilver, $jumlahGold, $total) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('INSERT INTO `'.TRANSAKSI_TABLE.'` (`'.TRANSAKSI_KODE.'`, `'.TRANSAKSI_ID_EVENT.'`, `'.TRANSAKSI_ID_MEMBER.'`, `'.TRANSAKSI_JUMLAH_REGULER.'`, `'.TRANSAKSI_JUMLAH_SILVER.'`, `'.TRANSAKSI_JUMLAH_GOLD.'`, `'.TRANSAKSI_TAGIHAN.'`, `'.TRANSAKSI_TERBAYAR.'`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->bind_param('iiiiiiii', $kode, $eventId, $memberId, $jumlahReguler, $jumlahSilver, $jumlahGold, $total, $bayar = 0);
			$stmt->execute();
			$stmt->close();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data ke database');
		}
	}

	function getTransaksiById($id) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('SELECT * FROM `'.TRANSAKSI_TABLE.'` WHERE `'.TRANSAKSI_ID.'` = ?');
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$hasil = $stmt->get_result()->fetch_assoc();
			$stmt->close();

			return $hasil;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data event ke database');
		}
	}

	function uploadBuktiTransfer($id, $bayar) {
		include 'mysqli_connect.php';

		try {
			$stmt = $mysqli->prepare('UPDATE `'.TRANSAKSI_TABLE.'` SET `'.TRANSAKSI_TERBAYAR.'` = ? WHERE `'.TRANSAKSI_ID.'` = ?');

			$stmt->bind_param('ii', $bayar, $id);
			$stmt->execute();
			$hasil = $stmt->affected_rows;
			$stmt->close();

			return $hasil>0 ? true : false;
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit('Gagal menyimpan data ke database');
		}
	}