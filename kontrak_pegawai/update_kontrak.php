<?php
include '../connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $id = intval($_POST['id']);
    $id_pegawai = intval($_POST['id_pegawai']);
    $tanggal_mulai_kontrak = $conn->real_escape_string($_POST['tanggal_mulai_kontrak']);
    $tanggal_berakhir_kontrak = $conn->real_escape_string($_POST['tanggal_berakhir_kontrak']);
    $status_kontrak = $conn->real_escape_string($_POST['status_kontrak']);
    $gaji_bulanan = $conn->real_escape_string($_POST['gaji_bulanan']);
    $tipe_kontrak = intval($_POST['tipe_kontrak']);

    // Update query
    $sql = "UPDATE `kontrak pegawai` SET 
            `id_pegawai` = '$id_pegawai', 
            `tanggal_mulai_kontrak` = '$tanggal_mulai_kontrak', 
            `tanggal_berakhir_kontrak` = '$tanggal_berakhir_kontrak', 
            `status_kontrak` = '$status_kontrak', 
            `gaji_bulanan` = '$gaji_bulanan', 
            `tipe_kontrak` = '$tipe_kontrak' 
            WHERE `id_pegawai` = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful update
        echo "<script>alert('Contract updated successfully!'); window.location.href = '../index\.php';</script>";
    } else {
        echo "<script>alert('Error updating contract: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>