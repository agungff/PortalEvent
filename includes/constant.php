<?php
	// hak akses
	define('HAK_AKSES_ADMIN', 1);
	define('HAK_AKSES_MEMBER', 3);
	
	// tabel member
	define('MEMBER_TABLE', 'tb_member');
	define('MEMBER_ID', 'id');
	define('MEMBER_NAMA_DEPAN', 'namaDepan');
	define('MEMBER_NAMA_BELAKANG', 'namaBelakang');
	define('MEMBER_NOMOR_HP', 'nomorHp');
	define('MEMBER_EMAIL', 'email');
	define('MEMBER_PASSWORD', 'password');
	define('MEMBER_HAK_AKSES', 'hakAkses');
	define('MEMBER_STATUS', 'status');

	// tabel aktivasi
	define('AKTIVASI_TABLE', 'tb_aktivasi');
	define('AKTIVASI_EMAIL', 'email');
	define('AKTIVASI_KODE', 'kode');

	// tabel event
	define('EVENT_TABLE', 'tb_event');
	define('EVENT_ID', 'id');
	define('EVENT_NAMA', 'nama');
	define('EVENT_DESKRIPSI', 'deskripsi');
	define('EVENT_LOKASI', 'lokasi');
	define('EVENT_HARGA_REGULER', 'hargaReguler');
	define('EVENT_HARGA_SILVER', 'hargaSilver');
	define('EVENT_HARGA_GOLD', 'hargaGold');
	define('EVENT_JUMLAH_REGULER', 'jumlahReguler');
	define('EVENT_JUMLAH_SILVER', 'jumlahSilver');
	define('EVENT_JUMLAH_GOLD', 'jumlahGold');
	define('EVENT_WAKTU_MULAI', 'waktuMulai');
	define('EVENT_WAKTU_SELESAI', 'waktuSelesai');
	define('EVENT_GAMBAR', 'gambar');
	
	// tabel transaksi
	define('TRANSAKSI_TABLE', 'tb_transaksi');
	define('TRANSAKSI_ID', 'id');
	define('TRANSAKSI_KODE', 'kode');
	define('TRANSAKSI_ID_EVENT', 'idEvent');
	define('TRANSAKSI_ID_MEMBER', 'idMember');
	define('TRANSAKSI_JUMLAH_REGULER', 'jumlahReguler');
	define('TRANSAKSI_JUMLAH_SILVER', 'jumlahSilver');
	define('TRANSAKSI_JUMLAH_GOLD', 'jumlahGold');
	define('TRANSAKSI_TAGIHAN', 'tagihan');
	define('TRANSAKSI_TERBAYAR', 'terbayar');
	
	
	
	
	
	
	
	
	