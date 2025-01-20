-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jan 2025 pada 06.08
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
-- Database: `hris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `ID_Absensi` int(11) NOT NULL,
  `ID_Pegawai` int(11) NOT NULL,
  `Tanggal_Waktu` datetime NOT NULL,
  `Status_Kehadiran` varchar(10) NOT NULL,
  `Metode_Verifikasi` varchar(20) NOT NULL,
  `Lokasi_IP` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `departemen`
--

CREATE TABLE `departemen` (
  `id_departemen` int(11) NOT NULL,
  `nama_departemen` varchar(100) NOT NULL,
  `kepala_departemen` varchar(100) NOT NULL,
  `lokasi_departemen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen pendukung`
--

CREATE TABLE `dokumen pendukung` (
  `dokumen_peg` int(11) NOT NULL,
  `kontrak_peg` int(11) NOT NULL,
  `jenis_dokumen` int(11) NOT NULL,
  `tanggal_unggah` date NOT NULL,
  `nama_file` text NOT NULL,
  `lokasi_file` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `desk_jabatan` text NOT NULL,
  `level_jabatan` tinyint(4) NOT NULL,
  `status_jabatan` enum('Tersedia','Tidak Tersedia') NOT NULL,
  `id_departemen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kehadiran`
--

CREATE TABLE `jadwal_kehadiran` (
  `ID_Jadwal` int(11) NOT NULL,
  `ID_Pegawai` int(11) NOT NULL,
  `Hari` varchar(10) NOT NULL,
  `Jam_Masuk` time NOT NULL,
  `Jam_Keluar` time NOT NULL,
  `Keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_cuti`
--

CREATE TABLE `jenis_cuti` (
  `id_jenis_cuti` int(11) NOT NULL,
  `nama_jenis_cuti` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterlambatan dan ketidakhadiran`
--

CREATE TABLE `keterlambatan dan ketidakhadiran` (
  `ID_ketidakhadiran` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jam_Masuk_Terlambat` time NOT NULL,
  `Alasan_Keterlambatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontrak pegawai`
--

CREATE TABLE `kontrak pegawai` (
  `id_kontrak` varchar(50) NOT NULL,
  `id_pegawai` varchar(50) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date NOT NULL,
  `status_kontrak` varchar(20) NOT NULL,
  `gaji_bulanan` decimal(10,0) NOT NULL,
  `tipe_kontrak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan`
--

CREATE TABLE `lowongan` (
  `id_lowongan` int(11) NOT NULL,
  `nama_lowongan` varchar(128) NOT NULL,
  `deskripsi_lowongan` text NOT NULL,
  `jabatan` varchar(128) NOT NULL,
  `tgl_posting` date NOT NULL,
  `tgl_tutup` date NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_peg` int(11) NOT NULL,
  `nama_peg` varchar(128) NOT NULL,
  `gender_peg` enum('Laki-laki','Perempuan') NOT NULL,
  `status_peg` varchar(128) NOT NULL,
  `almt_peg` text NOT NULL,
  `no_telp_peg` varchar(128) NOT NULL,
  `email_peg` varchar(128) NOT NULL,
  `jabatan_peg` varchar(11) NOT NULL,
  `ttl_peg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamar`
--

CREATE TABLE `pelamar` (
  `id_pelamar` int(11) NOT NULL,
  `nama_pel` varchar(128) NOT NULL,
  `email_pel` varchar(128) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `status_pel` enum('Diterima','Ditolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelatihan`
--

CREATE TABLE `pelatihan` (
  `id_pelatihan` int(11) NOT NULL,
  `nama_pelatihan` varchar(128) NOT NULL,
  `deskripsi_pelatihan` varchar(128) NOT NULL,
  `tgl_pelaksanaan` date NOT NULL,
  `jam_pelaksanaan` time NOT NULL,
  `durasi_pelatihan` varchar(128) NOT NULL,
  `lokasi_pelatihan` varchar(128) NOT NULL,
  `pemateri_pelatihan` varchar(128) NOT NULL,
  `status_pelatihan` enum('Terlaksana','Tidak Terlaksana') NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `kapasitas` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penghargaan`
--

CREATE TABLE `penghargaan` (
  `id_peng` int(11) NOT NULL,
  `nama_peng` varchar(128) NOT NULL,
  `jenis_peng` varchar(128) NOT NULL,
  `desk_peng` text NOT NULL,
  `id_peg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_KPI` int(11) NOT NULL,
  `nilai` int(11) NOT NULL,
  `periode penilaian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat perubahan kontrak`
--

CREATE TABLE `riwayat perubahan kontrak` (
  `id_perubahan` varchar(50) NOT NULL,
  `id_kontrak` varchar(50) NOT NULL,
  `tanggal_perubahan` date NOT NULL,
  `gaji_sebelum_perubahan` decimal(10,0) NOT NULL,
  `gaji_setelah_perubahan` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel cuti`
--

CREATE TABLE `tabel cuti` (
  `id_cuti` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_jenis_cuti` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_cuti` varchar(100) NOT NULL,
  `tanggal_pengajuan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_riwayat_cuti`
--

CREATE TABLE `tabel_riwayat_cuti` (
  `id_riwayat_cuti` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_jenis_cuti` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jumlah_hari` int(11) NOT NULL,
  `status_cuti` enum('Diterima','Selesai','Kadaluarsa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`ID_Absensi`);

--
-- Indeks untuk tabel `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id_departemen`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD UNIQUE KEY `id_departemen` (`id_departemen`);

--
-- Indeks untuk tabel `jadwal_kehadiran`
--
ALTER TABLE `jadwal_kehadiran`
  ADD PRIMARY KEY (`ID_Jadwal`);

--
-- Indeks untuk tabel `jenis_cuti`
--
ALTER TABLE `jenis_cuti`
  ADD PRIMARY KEY (`id_jenis_cuti`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id_lowongan`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_peg`);

--
-- Indeks untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id_pelamar`),
  ADD UNIQUE KEY `id_lowongan` (`id_lowongan`);

--
-- Indeks untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD PRIMARY KEY (`id_pelatihan`),
  ADD UNIQUE KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD PRIMARY KEY (`id_peng`),
  ADD UNIQUE KEY `id_peg` (`id_peg`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD UNIQUE KEY `id_pegawai` (`id_pegawai`),
  ADD UNIQUE KEY `id_KPI` (`id_KPI`);

--
-- Indeks untuk tabel `tabel cuti`
--
ALTER TABLE `tabel cuti`
  ADD PRIMARY KEY (`id_cuti`);

--
-- Indeks untuk tabel `tabel_riwayat_cuti`
--
ALTER TABLE `tabel_riwayat_cuti`
  ADD PRIMARY KEY (`id_riwayat_cuti`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `ID_Absensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kehadiran`
--
ALTER TABLE `jadwal_kehadiran`
  MODIFY `ID_Jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id_lowongan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_peg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id_pelamar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  MODIFY `id_pelatihan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penghargaan`
--
ALTER TABLE `penghargaan`
  MODIFY `id_peng` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD CONSTRAINT `pelamar_ibfk_1` FOREIGN KEY (`id_lowongan`) REFERENCES `lowongan` (`id_lowongan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pelatihan`
--
ALTER TABLE `pelatihan`
  ADD CONSTRAINT `pelatihan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_peg`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD CONSTRAINT `penghargaan_ibfk_1` FOREIGN KEY (`id_peg`) REFERENCES `pegawai` (`id_peg`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
