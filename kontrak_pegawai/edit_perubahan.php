<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
    exit;
}

$id = intval($_GET['id']); // Sanitize the ID

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM `riwayat_perubahan_kontrak` WHERE `id` = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan.'); window.history.back();</script>";
    exit;
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Edit Riwayat Perubahan Kontrak</h1>
        <form method="post" action="update_perubahan.php">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <div class="mb-3">
                <label for="id_kontrak" class="form-label">ID Kontrak</label>
                <input type="number" class="form-control" id="id_kontrak" name="id_kontrak" value="<?= $data['id_kontrak'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_perubahan" class="form-label">Tanggal Perubahan</label>
                <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" value="<?= $data['tanggal_perubahan'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="gaji_sebelum_perubahan" class="form-label">Gaji Sebelum Perubahan</label>
                <input type="number" class="form-control" id="gaji_sebelum_perubahan" name="gaji_sebelum_perubahan" value="<?= $data['gaji_sebelum_perubahan'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="gaji_setelah_perubahan" class="form-label">Gaji Setelah Perubahan</label>
                <input type="number" class="form-control" id="gaji_setelah_perubahan" name="gaji_setelah_perubahan" value="<?= $data['gaji_setelah_perubahan'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan_perubahan" class="form-label">Keterangan Perubahan</label>
                <input type="text" class="form-control" id="keterangan_perubahan" name="keterangan_perubahan" value="<?= $data['keterangan_perubahan'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</main>

<?php
include '../template/footer.php';
?>