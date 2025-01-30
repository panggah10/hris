<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $dokumen_peg = intval($_POST['dokumen_peg']);
    $kontrak_peg = intval($_POST['kontrak_peg']);
    $jenis_dokumen = intval($_POST['jenis_dokumen']);
    $tanggal_unggah = $_POST['tanggal_unggah'];
    $nama_file = $_POST['nama_file'];

    // Proses upload file
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['file_upload']['name']);
    $filePath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    // Validasi ekstensi file
    $allowedTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    if (!in_array($fileType, $allowedTypes)) {
        die("<script>alert('Hanya file PDF, DOC, DOCX, XLS, XLSX yang diizinkan!'); history.back();</script>");
    }

    // Buat direktori jika belum ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Upload file
    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $filePath)) {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO `dokumen pendukung` 
            (dokumen_peg, kontrak_peg, jenis_dokumen, tanggal_unggah, nama_file, lokasi_file) 
            VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("iiisss", $dokumen_peg, $kontrak_peg, $jenis_dokumen, $tanggal_unggah, $nama_file, $filePath);
        
        if ($stmt->execute()) {
            echo "<script>alert('Dokumen berhasil disimpan!'); window.location.href='index.php';</script>";
        } else {
            unlink($filePath); // Hapus file jika gagal simpan ke database
            echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "'); history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Gagal upload file!'); history.back();</script>";
    }
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Tambah Dokumen Pendukung</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="dokumen_peg" class="form-label">Dokumen Pegawai</label>
                <input type="number" class="form-control" id="dokumen_peg" name="dokumen_peg" required placeholder="Enter Dokumen Pegawai">
            </div>
            <div class="mb-3">
                <label for="kontrak_peg" class="form-label">Kontrak Pegawai</label>
                <input type="number" class="form-control" id="kontrak_peg" name="kontrak_peg" required placeholder="Enter Kontrak Pegawai">
            </div>
            <div class="mb-3">
                <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                <input type="number" class="form-control" id="jenis_dokumen" name="jenis_dokumen" required placeholder="Enter Jenis Dokumen">
            </div>
            <div class="mb-3">
                <label for="tanggal_unggah" class="form-label">Tanggal Unggah</label>
                <input type="date" class="form-control" id="tanggal_unggah" name="tanggal_unggah" required>
            </div>
            <div class="mb-3">
                <label for="nama_file" class="form-label">Nama File</label>
                <input type="text" class="form-control" id="nama_file" name="nama_file" required placeholder="Enter Nama File">
            </div>
            <div class="mb-3">
                <label for="file_upload" class="form-label">Upload File</label>
                <input type="file" class="form-control" id="file_upload" name="file_upload" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include '../template/footer.php'; ?>