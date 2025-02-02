<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID tidak valid!'); window.location.href='index.php';</script>";
    exit;
}

$id = (int)$_GET['id']; // Konversi ke integer

// Ambil data yang akan diedit
$stmt = $conn->prepare("SELECT * FROM `dokumen pendukung` WHERE dokumen_peg = ?");
if (!$stmt) {
    die("<script>alert('Gagal mempersiapkan query: " . addslashes($conn->error) . "'); window.location.href='index.php';</script>");
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$document = $result->fetch_assoc();
$stmt->close();

if (!$document) {
    echo "<script>alert('Dokumen tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Edit Dokumen Pendukung</h1>
        <form method="post" action="update_dokumen.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($document['dokumen_peg']) ?>">
            
            <div class="mb-3">
                <label for="dokumen_peg" class="form-label">Dokumen Pegawai</label>
                <input type="text" class="form-control" id="dokumen_peg" name="dokumen_peg" value="<?= htmlspecialchars($document['dokumen_peg']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="kontrak_peg" class="form-label">Kontrak Pegawai</label>
                <input type="text" class="form-control" id="kontrak_peg" name="kontrak_peg" value="<?= htmlspecialchars($document['kontrak_peg']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                <input type="text" class="form-control" id="jenis_dokumen" name="jenis_dokumen" value="<?= htmlspecialchars($document['jenis_dokumen']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_unggah" class="form-label">Tanggal Unggah</label>
                <input type="date" class="form-control" id="tanggal_unggah" name="tanggal_unggah" value="<?= htmlspecialchars($document['tanggal_unggah']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="nama_file" class="form-label">Nama File</label>
                <input type="text" class="form-control" id="nama_file" name="nama_file" value="<?= htmlspecialchars($document['nama_file']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="file_upload" class="form-label">Upload File Baru (Opsional)</label>
                <input type="file" class="form-control" id="file_upload" name="file_upload">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label">File Saat Ini</label>
                <div>
                    <a href="<?= htmlspecialchars($document['lokasi_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                        Lihat File
                    </a>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</main>

<?php include '../template/footer.php'; ?>