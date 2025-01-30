<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi ID
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
        exit;
    }

    $id = (int)$_POST['id']; // Konversi ke integer

    // Ambil data form
    $dokumen_peg = $_POST['dokumen_peg']; // Teks, bukan angka
    $kontrak_peg = $_POST['kontrak_peg']; // Teks, bukan angka
    $jenis_dokumen = $_POST['jenis_dokumen']; // Teks, bukan angka
    $tanggal_unggah = $_POST['tanggal_unggah'];
    $nama_file = $_POST['nama_file'];

    // Ambil lokasi file lama
    $stmt = $conn->prepare("SELECT lokasi_file FROM `dokumen pendukung` WHERE dokumen_peg = ?");
    if (!$stmt) {
        die("<script>alert('Gagal mempersiapkan query: " . addslashes($conn->error) . "'); window.history.back();</script>");
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldFile = $result->fetch_assoc()['lokasi_file'];
    $stmt->close();

    $newFilePath = $oldFile; // Default: gunakan file lama

    // Proses upload file baru jika ada
    if (!empty($_FILES['file_upload']['name'])) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['file_upload']['name']);
        $newFilePath = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($newFilePath, PATHINFO_EXTENSION));

        // Validasi ekstensi file
        $allowedTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
        if (!in_array($fileType, $allowedTypes)) {
            die("<script>alert('Hanya file PDF, DOC, DOCX, XLS, XLSX yang diizinkan!'); history.back();</script>");
        }

        // Buat direktori jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Upload file baru
        if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $newFilePath)) {
            // Hapus file lama jika ada
            if ($oldFile && file_exists($oldFile)) {
                unlink($oldFile);
            }
        } else {
            echo "<script>alert('Gagal upload file baru!'); history.back();</script>";
            exit;
        }
    }

    // Update data di database
    $stmt = $conn->prepare("UPDATE `dokumen pendukung` SET
        dokumen_peg = ?,
        kontrak_peg = ?,
        jenis_dokumen = ?,
        tanggal_unggah = ?,
        nama_file = ?,
        lokasi_file = ?
        WHERE dokumen_peg = ?");
    if (!$stmt) {
        die("<script>alert('Gagal mempersiapkan query: " . addslashes($conn->error) . "'); window.history.back();</script>");
    }

    $stmt->bind_param("ssssssi", $dokumen_peg, $kontrak_peg, $jenis_dokumen, $tanggal_unggah, $nama_file, $newFilePath, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Dokumen berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . addslashes($stmt->error) . "'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>