<?php
include '../connection.php'; // Pastikan file config.php sudah menggunakan koneksi berorientasi objek

// Ambil ID pegawai dari URL
$id_peg = $_GET['id'];

// Query untuk mengambil nama file foto
$query = "SELECT foto_peg FROM pegawai WHERE id_peg = $id_peg";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $namaFileFoto = $row['foto_peg'];

    // Hapus file foto dari folder
    if ($namaFileFoto && file_exists("D:/Amali Poenya/Instalasi xampp/xampp/htdocs/hris/img/" . $namaFileFoto)) {
        unlink("D:/Amali Poenya/Instalasi xampp/xampp/htdocs/hris/img/" . $namaFileFoto);
    }

    // Hapus data pegawai dari database
    $query = "DELETE FROM pegawai WHERE id_peg = $id_peg";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data pegawai berhasil dihapus.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Data pegawai tidak ditemukan.'); window.location.href='index.php';</script>";
}
?>