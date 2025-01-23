<?php
include 'koneksi.php'; // Koneksi ke database

$query = "SELECT * FROM mutasi JOIN karyawan ONutasi.karyawan_id = karyawan.id";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "Nama: " . $row['nama'] . " - Jenis: " . $row['jenis'] . " - Posisi Baru: " . $row['posisi_baru'] . " - Gaji Baru: " . $row['gaji_baru'] . " - Tanggal: " . $row['tanggal'] . " ";
    echo "<a href='edit_promosi_mutasi.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='hapus_promosi_mutasi.php?id=" . $row['id'] . "'>Hapus</a><br>";
}
?>