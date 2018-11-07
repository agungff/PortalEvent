-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 07 Nov 2018 pada 11.00
-- Versi Server: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webuser_portalevent`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_aktivasi`
--

CREATE TABLE `tb_aktivasi` (
  `email` varchar(50) NOT NULL,
  `kode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_event`
--

CREATE TABLE `tb_event` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` text NOT NULL,
  `hargaReguler` int(11) NOT NULL,
  `hargaSilver` int(11) NOT NULL,
  `hargaGold` int(11) NOT NULL,
  `jumlahReguler` int(11) NOT NULL,
  `jumlahSilver` int(11) NOT NULL,
  `jumlahGold` int(11) NOT NULL,
  `waktuMulai` datetime NOT NULL,
  `waktuSelesai` datetime NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_event`
--

INSERT INTO `tb_event` (`id`, `nama`, `deskripsi`, `lokasi`, `hargaReguler`, `hargaSilver`, `hargaGold`, `jumlahReguler`, `jumlahSilver`, `jumlahGold`, `waktuMulai`, `waktuSelesai`, `gambar`) VALUES
(1, 'SeaWorld Ancol', '', 'Ancol - Jl. Lodan Timur', 85000, 0, 0, 10000, 0, 0, '2018-05-17 00:01:00', '2018-06-17 23:59:00', '1526281242.jpg'),
(2, 'Ocean Dream Samudra', '', 'Ancol - Jl. Lodan Timur', 90000, 160000, 0, 2000, 1000, 0, '2018-05-17 00:01:00', '2018-06-17 23:59:00', '1526281361.jpg'),
(3, 'Bali Zoo Entrance Ticket', 'Dari setiap tiket masuk yang terjual, Rp. 1000,00 akan didonasikan ke Bali Zoo Turtle Conservation untuk  menyelamatkan penyu.\r\n\r\nSelamat Datang Di Bali Zoo\r\n\r\nBerlokasi di desa Singapadu, Bali Zoo yang rindang dipenuhi dengan  pepohonan tropis, memiliki lebih dari 500 satwa termasuk satwa langka seperti Gajah Sumatra, Orangutan, Harimau Benggala, Binturong, dan Singa Afrika. Para pengunjung dapat berinteraksi secara langsung dengan satwa-satwa jinak yang terlatih dan jangan lewatkan kesempatan untuk berfoto bersama satwa langka ini!\r\n\r\nAnimal Encounters\r\n\r\nNikmati kesempatan terunik di Bali, berinteraksi secara dekat dan jangan lewatkan kesempatan berfoto dengan satwa-satwa jinak di Bali Zoo, seperti: anak harimau Benggala, buaya, binturong, ular dan lainnya selama sesi program Animal Encounter berlangusng\r\n\r\nSetiap hari, pukul 13:00dan 16:00 di Elephant View Restaurant.  \r\n\r\nExotic Bird Show\r\n\r\nSaksikan pertunjukkan burung yang menawan seperti aksi burung elang menukik diatas puncak pepohonan dan beragam aksi dari burung eksotik lainnya. Anda tidak hanya bisa dekat dengan burung yang mengagumkan namun juga akan memperoleh wawasan tentang dunia burung yang menarik.\r\n\r\nSetiap hari, pukul 11:00 dan 15:00\r\n\r\nPetting Zoo\r\n\r\nBerinteraksi dengan berbagai satwa jinak yang menggemaskan, mulai dari melihat, membelai hingga memberi makanan serta belajar mengenal habitat aslinya, seperti kelinci, wallaby, dan rusa Timor.\r\n\r\nSetiap hari, pukul 09:00 dan 05:00\r\n\r\nFeed The Animals\r\n\r\nJangan lewatkan kesempatan langka untuk memberi makan satwa secara langsung. Mulai dari dari memberi makan singa, harimau, burung lorry hingga memancing buaya dengan daging ayam\r\n\r\nSetiap hari, pukul 09:00 dan 05:00\r\n\r\nDine With Wild Life\r\n\r\nMenikmati hidangan di Elephant View Restaurant sambil mengagumi parade gajah yang melintasi taman hijau yang dihiasi deretan burung-burung eksotik atau nikmati sajian istimewa di WANA Restaurant, Lounge, Bar yang berjarak sangat dekat dari keluarga kerajaan Singa Afrika,  akan menjadi pengalaman yang sangat unik dan tak terlupakan.\r\n\r\nZoovenirs\r\n\r\nLengkapi koleksi pribadi anda dengan berbagai souvenir cantik dan unik seperti boneka, baju, topi, frame foto dan aneka souvenir binatang  yang hanya bisa anda dapat kan di Bali Zoo.\r\n\r\nMiniapolis Jungle Waterplay\r\n\r\nSetelah puas melihat dan berinteraksi dengan berbagai satwa yang ada di Bali Zoo, Anda dan keluarga bisa menikmati kesegaran bermain air di Miniapolis Jungle. Outdoor waterpark ini menawarkan tempat untuk relax dan menikmati hangatnya matahari serta berbagai wahana permainan seperti giant bucket water splash, water slide, dan sebagainya. Sementara anak Anda bermain, Anda bisa menikmati minuman segar di cafe maupun bersantai di cabana yang tersedia di dalam area.\r\n\r\nNight At The Zoo\r\n\r\nBerpetualang di malam hari mengelilingi kebun binatang dengan diiringi nyanyian khas satwa yang akan memandu anda melihat aktivitas berbagai satwa malam. Makan malam ekslusif di bawah langit malam yang berjarak sangat dekat dengan kerajaan Singa, diiringi Fire Dance yang semakin menghidupkan suasana malam yang romantis.\r\n\r\nCorporate Event\r\n\r\nBali Zoo menawarkan berbagai fasilitas menarik untuk menyelenggarakan event spesial seperti: jamuan malan malam, meeting, arisan, pernikahan hingga acara penggalangan dana. Suasana menjadi lengkap dengan kehadiran berbagai satwa liar di Bali Zoo yang eksotis.\r\n\r\nBreakfast with Orangutans\r\n\r\nPertama di Indonesia, Santap pagi bersama orangutan dengan berbagai pilihan makanan lezat baik nasional maupun internasional. Berinteraksi langsung dengan satwa pintar yang sangat menggemaskan.\r\n\r\nElephant Expedition\r\n\r\nBerwisata naik gajah terbaik dengan trek paling indah akan anda rasakan di Bali Zoo. Berkeliling bersama Gajah Sumatra yang sangat pintar dan Mahout berpengalaman, akan membawa anda menikmati pemandangan dari sisi yang berbeda dan tak terlupakan. Menyusuri jalur khusus dengan pemandangan disekitar Bali Zoo.', 'Bali Zoo - Jl. Raya Singapadu, Sukawati, Gianyar, Gianyar', 90000, 130000, 0, 2000, 1000, 0, '2018-05-15 00:00:00', '2018-12-31 12:00:00', '1526281614.jpg'),
(4, 'Atlantis Water Adventure', '', 'ANCOL - Jl. Lodan Timur', 57500, 257500, 0, 2000, 1000, 0, '2018-05-15 07:00:00', '2018-12-31 20:00:00', '1526281841.jpg'),
(5, 'BALI SUPER PASS ACTIVITY', 'SILAHKAN PILIH TANGGAL KEDATANGAN ANDA\r\n\r\nHUBUNGI 0811-398-1515 atau email ke balisuperpass.cs@kura2bali.com untuk konfirmasi kedatangan anda max 2 (dua) hari sebelum tanggal kunjungan dengan memberikan voucher anda sebagai bukti pembelian. NO REFUND!', 'Bali - Bali', 600000, 800000, 1000000, 3000, 2000, 1000, '2018-05-15 07:00:00', '2018-12-31 20:00:00', '1526282284.jpg'),
(6, 'Taman Legenda Keong Emas TMII Jakarta', 'Taman Legenda adalah sebuah tempat wisata keluarga yang terletak di dalam area Taman Mini Indonesia Indah Jakarta Timur.\r\n\r\nPengunjung bisa menikmati berbagai wahana dan permainan yang sangat menarik di Taman Legenda. Diantaranya Petualangan Dinosaurus, Mata Legenda, Nirwata Kisar, Kapal Bajak Laut, Mobil Tanjak, Kereta Beos, Ulat Selur, Pojok Edukasi hingga permainan air untuk anak-anak.\r\n\r\nBerbagai macam permainan yang dapat dimainkan oleh seluruh keluarga ini, tentunya dapat menjadikan kunjungan ke Taman Legenda pengalaman yang mengesankan.', 'Taman Mini Indonesia Indah - Jalan Raya TMII, Jakarta Timur', 95000, 0, 0, 2500, 0, 0, '2018-10-10 00:00:00', '2018-10-31 12:00:00', '1526282426.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_member`
--

CREATE TABLE `tb_member` (
  `id` int(11) NOT NULL,
  `namaDepan` varchar(25) NOT NULL,
  `namaBelakang` varchar(25) NOT NULL,
  `nomorHp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hakAkses` tinyint(4) NOT NULL DEFAULT '3',
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_member`
--

INSERT INTO `tb_member` (`id`, `namaDepan`, `namaBelakang`, `nomorHp`, `email`, `password`, `hakAkses`, `status`) VALUES
(1, 'Admin', 'Web', '085729349718', 'admin@portal-event.com', '$2y$10$csSob5Rv0g.IE8IYFAG1J.5Bl3uK5bJoAOPBinHiyWf7EF39gfgqK', 1, 1),
(2, 'Agung', 'Febriyanto', '085729349718', 'agungff@gmail.com', '$2y$10$jsx8M7CkYnF99/THwlPsrO7wnvIO3nYBy4Y2/iy5PFAYsbaOLByWi', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `idEvent` int(11) NOT NULL,
  `idMember` int(11) NOT NULL,
  `jumlahReguler` int(11) NOT NULL,
  `jumlahSilver` int(11) NOT NULL,
  `jumlahGold` int(11) NOT NULL,
  `tagihan` int(11) NOT NULL,
  `terbayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id`, `kode`, `idEvent`, `idMember`, `jumlahReguler`, `jumlahSilver`, `jumlahGold`, `tagihan`, `terbayar`) VALUES
(1, '1526282609', 5, 2, 5, 3, 2, 7400000, 7400000),
(2, '1526282800', 2, 2, 0, 4, 0, 640000, 640000),
(3, '1527994719', 1, 2, 2, 0, 0, 170000, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_aktivasi`
--
ALTER TABLE `tb_aktivasi`
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
