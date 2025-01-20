<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal_mulai = $_POST['tanggal_mulai_kontrak'];
    $tanggal_berakhir = $_POST['tanggal_berakhir_kontrak'];
    $status_kontrak = $_POST['status_kontrak'];
    $gaji_bulanan = $_POST['gaji_bulanan'];
    $tipe_kontrak = $_POST['tipe_kontrak'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO `kontrak pegawai` (id_pegawai, tanggal_mulai_kontrak, tanggal_berakhir_kontrak, status_kontrak, gaji_bulanan, tipe_kontrak) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $id_pegawai, $tanggal_mulai, $tanggal_berakhir, $status_kontrak, $gaji_bulanan, $tipe_kontrak);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Kontrak pegawai berhasil disimpan.";
    } else {
        echo "Terjadi kesalahan saat menyimpan kontrak pegawai: " . $stmt->error; // Improved error handling
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
