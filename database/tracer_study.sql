-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Okt 2024 pada 17.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracer_study`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_kuesioner`
--

CREATE TABLE `event_kuesioner` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `dibuat_oleh` int(11) NOT NULL,
  `tahun_lulusan_mulai` year(4) DEFAULT NULL,
  `tahun_lulusan_selesai` year(4) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_pengembangan_karir`
--

CREATE TABLE `event_pengembangan_karir` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `deskripsi_event` text DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `dibuat_oleh` int(11) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran_event`
--

CREATE TABLE `pendaftaran_event` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('admin','alumni') NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `tahun_lulusan` year(4) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_alumni`
--

CREATE TABLE `profil_alumni` (
  `id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `email_alternatif` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `diperbarui_pada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `respon_kuesioner`
--

CREATE TABLE `respon_kuesioner` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `pengguna_id` int(11) NOT NULL,
  `status_kerja` enum('bekerja','menganggur','lanjut_pendidikan') NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `bidang_pekerjaan` varchar(255) DEFAULT NULL,
  `pekerjaan_relevan` tinyint(1) DEFAULT NULL,
  `pekerjaan_sesuai_passion` tinyint(1) DEFAULT NULL,
  `jenjang_pendidikan` varchar(255) DEFAULT NULL,
  `nama_institusi` varchar(255) DEFAULT NULL,
  `jurusan_pendidikan` varchar(255) DEFAULT NULL,
  `pendidikan_sesuai_jurusan_sekolah` tinyint(1) DEFAULT NULL,
  `pendidikan_sesuai_passion` tinyint(1) DEFAULT NULL,
  `diisi_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `event_kuesioner`
--
ALTER TABLE `event_kuesioner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `event_pengembangan_karir`
--
ALTER TABLE `event_pengembangan_karir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indeks untuk tabel `respon_kuesioner`
--
ALTER TABLE `respon_kuesioner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `event_kuesioner`
--
ALTER TABLE `event_kuesioner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `event_pengembangan_karir`
--
ALTER TABLE `event_pengembangan_karir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `respon_kuesioner`
--
ALTER TABLE `respon_kuesioner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `event_kuesioner`
--
ALTER TABLE `event_kuesioner`
  ADD CONSTRAINT `event_kuesioner_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event_pengembangan_karir`
--
ALTER TABLE `event_pengembangan_karir`
  ADD CONSTRAINT `event_pengembangan_karir_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran_event`
--
ALTER TABLE `pendaftaran_event`
  ADD CONSTRAINT `pendaftaran_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event_pengembangan_karir` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_event_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `profil_alumni`
--
ALTER TABLE `profil_alumni`
  ADD CONSTRAINT `profil_alumni_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `respon_kuesioner`
--
ALTER TABLE `respon_kuesioner`
  ADD CONSTRAINT `respon_kuesioner_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event_kuesioner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respon_kuesioner_ibfk_2` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
