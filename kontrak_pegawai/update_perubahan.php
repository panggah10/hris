<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $id = intval($_POST['id']);
    $id_kontrak = intval($_POST['id_kontrak']);
    $tanggal_perubahan = $conn->real_escape_string($_POST['tanggal_perubahan']);
    $gaji_sebelum_perubahan = floatval($_POST['gaji_sebelum_perubahan']);
    $gaji_setelah_perubahan = floatval($_POST['gaji_setelah_perubahan']);
    $keterangan_perubahan = $conn->real_escape_string($_POST['keterangan_perubahan']);

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE `riwayat_perubahan_kontrak` SET 
                            `id_kontrak` = ?, 
                            `tanggal_perubahan` = ?, 
                            `gaji_sebelum_perubahan` = ?, 
                            `gaji_setelah_perubahan` = ?, 
                            `keterangan_perubahan` = ? 
                            WHERE `id` = ?");
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("isddsi", $id_kontrak, $tanggal_perubahan, $gaji_sebelum_perubahan, $gaji_setelah_perubahan, $keterangan_perubahan, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Permintaan tidak valid.'); window.history.back();</script>";
}
?>