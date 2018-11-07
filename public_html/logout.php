<?php
	session_start();

	if (isset($_SESSION['id'])) {
		setcookie('logout', 1, time()+1);
	}

	session_unset();
	session_destroy();

	header('location: /');
?>