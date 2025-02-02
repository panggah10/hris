<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal_mulai_kontrak = $_POST['tanggal_mulai_kontrak'];
    $tanggal_berakhir_kontrak = $_POST['tanggal_berakhir_kontrak'];
    $status_kontrak = $_POST['status_kontrak'];
    $gaji_bulanan = $_POST['gaji_bulanan'];
    $tipe_kontrak = $_POST['tipe_kontrak'];

    // Insert data into the database
    $sql = "INSERT INTO `kontrak pegawai` (id_pegawai, tanggal_mulai_kontrak, tanggal_berakhir_kontrak, status_kontrak, gaji_bulanan, tipe_kontrak) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $id_pegawai, $tanggal_mulai_kontrak, $tanggal_berakhir_kontrak, $status_kontrak, $gaji_bulanan, $tipe_kontrak);

    if ($stmt->execute()) {
        echo "<script>alert('Kontrak pegawai berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kontrak pegawai.');</script>";
    }
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Tambah Kontrak Pegawai</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="id_pegawai" class="form-label">ID Pegawai</label>
                <input type="number" class="form-control" id="id_pegawai" name="id_pegawai" required placeholder="Enter Employee ID">
            </div>
            <div class="mb-3">
                <label for="tanggal_mulai_kontrak" class="form-label">Tanggal Mulai Kontrak</label>
                <input type="date" class="form-control" id="tanggal_mulai_kontrak" name="tanggal_mulai_kontrak" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_berakhir_kontrak" class="form-label">Tanggal Berakhir Kontrak</label>
                <input type="date" class="form-control" id="tanggal_berakhir_kontrak" name="tanggal_berakhir_kontrak" required>
            </div>
            <div class="mb-3">
                <label for="status_kontrak" class="form-label">Status Kontrak</label>
                <select class="form-select" id="status_kontrak" name="status_kontrak" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gaji_bulanan" class="form-label">Gaji Bulanan</label>
                <input type="text" class="form-control" id="gaji_bulanan" name="gaji_bulanan" required placeholder="Enter Monthly Salary">
            </div>
            <div class="mb-3">
                <label for="tipe_kontrak" class="form-label">Tipe Kontrak</label>
                <select class="form-select" id="tipe_kontrak" name="tipe_kontrak" required>
                    <option value="1">Tetap</option>
                    <option value="2">Kontrak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sumbit</button>
        </form>
    </div>
</main>

<?php
include '../template/footer.php';
?>
