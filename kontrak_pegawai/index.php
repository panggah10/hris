<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Function to retrieve data from a table
function getData($table) {
    global $conn; // Use the global connection variable
    $result = $conn->query("SELECT * FROM `$table`");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if there's an error
    }
}

// Fetch data from kontrak_pegawai table
$kontrak_pegawai = getData('kontrak pegawai');

// Function to retrieve change history data
function getChangeHistory() {
    global $conn; // Use the global connection variable
    $result = $conn->query("SELECT * FROM `riwayat perubahan kontrak` ORDER BY `tanggal_perubahan` DESC");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if there's an error
    }
}

// Fetch data from change_history table
$change_history = getChangeHistory();
?>
<main id="main" class="main">
    <div class="container">
        <h1>Manajemen Kontrak Pegawai</h1>
        <ul class="nav nav-tabs" id="kontrakPegawaiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="kontrak-tab" data-bs-toggle="tab" href="#kontrak" role="tab" aria-controls="kontrak" aria-selected="true">Data Kontrak Pegawai</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="riwayat-tab" data-bs-toggle="tab" href="#riwayat" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat Perubahan</a>
            </li>
        </ul>
        <div class="tab-content" id="kontrakPegawaiTabContent">
            <div class="tab-pane fade show active" id="kontrak" role="tabpanel" aria-labelledby="kontrak-tab">
                <h2>Tambah Kontrak Pegawai</h2>
                <form method="post" action="submit_kontrak.php">
                    <div class="mb-3">
                        <label for="id_pegawai" class="form-label">ID Pegawai</label>
                        <input type="number" class="form-control" id="id_pegawai" name="id_pegawai" required>
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
                        <input type="text" class="form-control" id="gaji_bulanan" name="gaji_bulanan" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipe_kontrak" class="form-label">Tipe Kontrak</label>
                        <select class="form-select" id="tipe_kontrak" name="tipe_kontrak" required>
                            <option value="1">Tetap</option>
                            <option value="2">Kontrak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <h2 class="mt-4">Daftar Kontrak Pegawai</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pegawai</th>
                            <th>Tanggal Mulai Kontrak</th>
                            <th>Tanggal Berakhir Kontrak</th>
                            <th>Status Kontrak</th>
                            <th>Gaji Bulanan</th>
                            <th>Tipe Kontrak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kontrak_pegawai as $row): ?>
                            <tr>
                                <td><?= $row['id_pegawai'] ?></td>
                                <td><?= $row['tanggal_mulai_kontrak'] ?></td>
                                <td><?= $row['tanggal_berakhir_kontrak'] ?></td>
                                <td><?= $row['status_kontrak'] ?></td>
                                <td><?= $row['gaji_bulanan'] ?></td>
                                <td><?= $row['tipe_kontrak'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <h2>Riwayat Perubahan Kontrak Pegawai</h2>
                <form method="post" action="submit_change_history.php">
                    <div class="mb-3">
                        <label for="id_kontrak" class="form-label">ID Kontrak</label>
                        <input type="text" class="form-control" id="id_kontrak" name="id_kontrak" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_perubahan" class="form-label">Tanggal Perubahan</label>
                        <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" required>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_sebelum" class="form-label">Gaji Sebelum Perubahan</label>
                        <input type="text" class="form-control" id="gaji_sebelum" name="gaji_sebelum" required>
                    </div>
                    <div class="mb-3">
                        <label for="gaji_setelah" class="form-label">Gaji Setelah Perubahan</label>
                        <input type="text" class="form-control" id="gaji_setelah" name="gaji_setelah" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_perubahan" class="form-label">Keterangan Perubahan</label>
                        <input type="text" class="form-control" id="keterangan_perubahan" name="keterangan_perubahan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log Perubahan</button>
                </form>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Tanggal Perubahan</th>
                            <th>Gaji Sebelum Perubahan</th>
                            <th>Gaji Setelah Perubahan</th>
                            <th>Keterangan Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($change_history as $row): ?>
                            <tr>
                                <td><?= $row['id_kontrak'] ?></td>
                                <td><?= $row['tanggal_perubahan'] ?></td>
                                <td><?= $row['gaji_sebelum_perubahan'] ?></td>
                                <td><?= $row['gaji_setelah_perubahan'] ?></td>
                                <td><?= $row['keterangan_perubahan'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<!-- Add CSS for transition -->
<style>
    .tab-pane {
        transition: all 0.5s ease;
    }
</style>

<!-- Add JavaScript for tab switching -->
<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('href'));
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            target.classList.add('show', 'active');
        });
    });
</script>

<?php
include '../template/footer.php';
?>
