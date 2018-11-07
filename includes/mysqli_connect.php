<?php
	$DB_HOSTNAME = '127.0.0.1';
	$DB_USERNAME = 'webuser';
	$DB_PASSWORD = 'password';
	$DB_DATABASE = 'webuser_portalevent';
	
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	try {
		$mysqli = new mysqli($DB_HOSTNAME, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
		$mysqli->set_charset('utf8mb4');
	} catch (Exception $e) {
		error_log($e->getMessage());
		exit('Gagal terhubung dengan database');
	}
	