<?php
include '../connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']); // Sanitize the ID

// Prepare and execute the delete query
$stmt = $conn->prepare("DELETE FROM `riwayat_perubahan_kontrak` WHERE `id` = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus data: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>