<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('ID not provided. Please provide a valid ID.'); window.history.back();</script>";
    exit;
}

$id = $_GET['id'];

// Fetch existing contract data
$result = $conn->query("SELECT * FROM `kontrak pegawai` WHERE `id_pegawai` = '$id'");
$contract = $result->fetch_assoc();

if (!$contract) {
    echo "<script>alert('Contract not found. Please check the ID.'); window.history.back();</script>";
    exit;
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Edit Kontrak Pegawai</h1>
        <form method="post" action="update_kontrak.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($contract['id_pegawai']) ?>">
            <div class="mb-3">
                <label for="id_pegawai" class="form-label">ID Pegawai</label>
                <input type="number" class="form-control" id="id_pegawai" name="id_pegawai" value="<?= htmlspecialchars($contract['id_pegawai']) ?>" required placeholder="Enter Employee ID">
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai_kontrak" class="form-label">Tanggal Mulai Kontrak</label>
                <input type="date" class="form-control" id="tanggal_mulai_kontrak" name="tanggal_mulai_kontrak" value="<?= htmlspecialchars($contract['tanggal_mulai_kontrak']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_berakhir_kontrak" class="form-label">Tanggal Berakhir Kontrak</label>
                <input type="date" class="form-control" id="tanggal_berakhir_kontrak" name="tanggal_berakhir_kontrak" value="<?= htmlspecialchars($contract['tanggal_berakhir_kontrak']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="status_kontrak" class="form-label">Status Kontrak</label>
                <select class="form-select" id="status_kontrak" name="status_kontrak" required>
                    <option value="Aktif" <?= $contract['status_kontrak'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Nonaktif" <?= $contract['status_kontrak'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gaji_bulanan" class="form-label">Gaji Bulanan</label>
                <input type="text" class="form-control" id="gaji_bulanan" name="gaji_bulanan" value="<?= htmlspecialchars($contract['gaji_bulanan']) ?>" required placeholder="Enter Monthly Salary">
            </div>
            <div class="mb-3">
                <label for="tipe_kontrak" class="form-label">Tipe Kontrak</label>
                <select class="form-select" id="tipe_kontrak" name="tipe_kontrak" required>
                    <option value="1" <?= $contract['tipe_kontrak'] == '1' ? 'selected' : '' ?>>Tetap</option>
                    <option value="2" <?= $contract['tipe_kontrak'] == '2' ? 'selected' : '' ?>>Kontrak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Contract</button>
        </form>
    </div>
</main>

<?php
include '../template/footer.php';
?>