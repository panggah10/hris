-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jan 2025 pada 08.19
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
-- Struktur dari tabel `analisis_sdm`
--

CREATE TABLE `analisis_sdm` (
  `id_analisis` int(11) NOT NULL,
  `judul_analisis` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_analisis` date NOT NULL,
  `jenis_analisis` enum('Kehadiran','Kinerja','Pelatihan','Penghargaan') NOT NULL
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

--
-- Dumping data untuk tabel `departemen`
--

INSERT INTO `departemen` (`id_departemen`, `nama_departemen`, `kepala_departemen`, `lokasi_departemen`) VALUES
(1, 'Sumber Daya Manusia', 'Diana Putri', 'Lantai 3, Gedung A');

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

--
-- Dumping data untuk tabel `kontrak pegawai`
--

INSERT INTO `kontrak pegawai` (`id_kontrak`, `id_pegawai`, `tanggal_mulai`, `tanggal_berakhir`, `status_kontrak`, `gaji_bulanan`, `tipe_kontrak`) VALUES
('', '1', '2003-02-23', '3343-02-12', 'Aktif', 3000000, '12'),
('', '12', '3444-03-12', '0033-04-04', 'Nonaktif', 3000000, 'aktif'),
('', '12', '3444-03-12', '0033-04-04', 'Nonaktif', 3000000, 'aktif'),
('', '2123026', '2005-04-27', '9999-09-10', 'Aktif', 10, 'Tetap'),
('', '1112233', '0335-02-12', '0007-07-06', 'Nonaktif', 10, 'Tetap');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kpi`
--

CREATE TABLE `kpi` (
  `id_kpi` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `target` varchar(128) NOT NULL,
  `bobot` varchar(128) NOT NULL,
  `id_peg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_sdm`
--

CREATE TABLE `laporan_sdm` (
  `id_laporan` int(11) NOT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `isi_laporan` text NOT NULL,
  `tanggal_dibuat` date NOT NULL
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
-- Struktur dari tabel `mutasi`
--

CREATE TABLE `mutasi` (
  `id_mutasi` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `dep_lama` varchar(50) NOT NULL,
  `dep_baru` varchar(50) NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `alasan_mutasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Struktur dari tabel `penggajian`
--

CREATE TABLE `penggajian` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(120) NOT NULL,
  `id_penggajian` int(11) NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL,
  `id_tunjangan` int(11) NOT NULL,
  `tj_transportasi` varchar(50) NOT NULL,
  `tj_kesehatan` varchar(50) NOT NULL,
  `bonus` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Struktur dari tabel `pengunduran_diri`
--

CREATE TABLE `pengunduran_diri` (
  `id_pengunduran` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_efektif` date NOT NULL,
  `alasan` text NOT NULL,
  `status_pengajuan` enum('Menunggu','Disetujui','Ditolak','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Struktur dari tabel `penilaian_pelamar`
--

CREATE TABLE `penilaian_pelamar` (
  `id_penilaian_pel` int(11) NOT NULL,
  `id_pelamar` int(11) NOT NULL,
  `id_tahap` int(11) NOT NULL,
  `tgl_dinilai` date NOT NULL,
  `skor` int(11) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `phk`
--

CREATE TABLE `phk` (
  `id_phk` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal_phk` date NOT NULL,
  `alasan_phk` text NOT NULL,
  `status_kompensasi` enum('Diberikan','Tidak Diberikan','','') NOT NULL,
  `jumlah_kompensasi` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `potongan_gaji`
--

CREATE TABLE `potongan_gaji` (
  `id` int(11) NOT NULL,
  `potongan` varchar(120) NOT NULL,
  `jml_potongan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `promosi`
--

CREATE TABLE `promosi` (
  `id_promosi` int(11) NOT NULL,
  `id_peg` int(11) NOT NULL,
  `jab_lama` varchar(50) NOT NULL,
  `jab_baru` varchar(50) NOT NULL,
  `tgl_promosi` date NOT NULL,
  `alasan_promosi` text NOT NULL
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
  `gaji_setelah_perubahan` decimal(10,0) NOT NULL,
  `keterangan_perubahan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat perubahan kontrak`
--

INSERT INTO `riwayat perubahan kontrak` (`id_perubahan`, `id_kontrak`, `tanggal_perubahan`, `gaji_sebelum_perubahan`, `gaji_setelah_perubahan`, `keterangan_perubahan`) VALUES
('', '1112233', '2025-01-21', 0, 10, ''),
('', '2123026', '2025-01-21', 1, 100, ''),
('', '2123026', '2025-01-21', 1, 100, ''),
('', '2123026', '2025-01-21', 1, 100, ''),
('', '123456', '2025-01-21', 20, 30, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `slip_gaji`
--

CREATE TABLE `slip_gaji` (
  `id_slip_gaji` int(11) NOT NULL,
  `bulan_tahun` date NOT NULL,
  `gaji_pokok` decimal(30,0) NOT NULL,
  `tunjangan` decimal(30,0) NOT NULL,
  `potongan` decimal(30,0) NOT NULL,
  `total_gaji` decimal(30,0) NOT NULL,
  `id_peg` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahap_lamaran`
--

CREATE TABLE `tahap_lamaran` (
  `id_tahap` int(11) NOT NULL,
  `nama_tahap` varchar(128) NOT NULL,
  `deskripsi_tahap` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`ID_Absensi`);

--
-- Indeks untuk tabel `analisis_sdm`
--
ALTER TABLE `analisis_sdm`
  ADD PRIMARY KEY (`id_analisis`);

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
-- Indeks untuk tabel `kpi`
--
ALTER TABLE `kpi`
  ADD PRIMARY KEY (`id_kpi`),
  ADD UNIQUE KEY `id_peg` (`id_peg`);

--
-- Indeks untuk tabel `laporan_sdm`
--
ALTER TABLE `laporan_sdm`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id_lowongan`);

--
-- Indeks untuk tabel `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`id_mutasi`);

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
-- Indeks untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id_jabatan`);

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
  MODIFY `id_departemen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
