<?php
include '../connection.php';

// Debug: Tampilkan parameter id
echo "<script>console.log('ID yang diterima: " . ($_GET['id'] ?? 'Tidak ada') . "');</script>";

// Validasi ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
    exit;
}

$id = $_GET['id']; // Tidak perlu konversi ke integer jika id berupa string

// Ambil data file sebelum menghapus
$stmt = $conn->prepare("SELECT lokasi_file FROM `dokumen pendukung` WHERE dokumen_peg = ?");
if (!$stmt) {
    die("<script>alert('Gagal mempersiapkan query: " . addslashes($conn->error) . "'); window.history.back();</script>");
}

$stmt->bind_param("s", $id); // Gunakan "s" jika dokumen_peg adalah string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

$data = $result->fetch_assoc();
$filePath = $data['lokasi_file']; // Path file yang akan dihapus
$stmt->close();

// Hapus data dari database
$stmt = $conn->prepare("DELETE FROM `dokumen pendukung` WHERE dokumen_peg = ?");
if (!$stmt) {
    die("<script>alert('Gagal mempersiapkan query: " . addslashes($conn->error) . "'); window.history.back();</script>");
}

$stmt->bind_param("s", $id); // Gunakan "s" jika dokumen_peg adalah string

if ($stmt->execute()) {
    // Hapus file fisik jika ada
    if ($filePath && file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "<script>alert('Dokumen dan file berhasil dihapus!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Dokumen berhasil dihapus, tetapi gagal menghapus file fisik!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Dokumen berhasil dihapus!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Gagal menghapus data: " . addslashes($stmt->error) . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>