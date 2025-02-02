<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Function to retrieve data from a table
function getData($table) {
    global $conn; // Use the global connection variable
    $result = $conn->query("SELECT * FROM `$table` WHERE `status_kontrak` = 'Aktif'"); // Only show active contracts
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
    $result = $conn->query("SELECT * FROM `riwayat_perubahan_kontrak` ORDER BY `tanggal_perubahan` DESC");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if there's an error
    }
}

// Fetch data from change_history table
$change_history = getChangeHistory();

// Function to retrieve documents
function getDocuments() {
    global $conn; // Use the global connection variable
    $result = $conn->query("SELECT * FROM `dokumen pendukung` ORDER BY `tanggal_unggah` DESC");
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Return an empty array if there's an error
    }
}

// Fetch data from documents table
$documents = getDocuments();
?>
<main id="main" class="main">
    <?php if (isset($_GET['message']) && $_GET['message'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            Kontrak pegawai berhasil diperbarui!
        </div>
    <?php endif; ?>

    <div class="container">
        <h1>Manajemen Kontrak Pegawai</h1>
        <ul class="nav nav-tabs" id="kontrakPegawaiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="kontrak-tab" data-bs-toggle="tab" href="#kontrak" role="tab" aria-controls="kontrak" aria-selected="true">Data Kontrak Pegawai</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="riwayat-tab" data-bs-toggle="tab" href="#riwayat" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat Perubahan</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="dokumen-tab" data-bs-toggle="tab" href="#dokumen" role="tab" aria-controls="dokumen" aria-selected="false">Dokumen Pendukung</a>
            </li>
        </ul>
        <div class="tab-content" id="kontrakPegawaiTabContent">
            <div class="tab-pane fade show active" id="kontrak" role="tabpanel" aria-labelledby="kontrak-tab">
                <h2 class="mt-4"></h2>
                <button class="btn btn-primary mb-3" onclick="window.location.href='submit_kontrak.php'">Tambah Kontrak Pegawai</button>
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
                            <th>Update Kontrak Pegawai</th>
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
                                <td>
                                    <a href="edit_kontrak.php?id=<?= $row['id_pegawai'] ?>" class="btn btn-warning">Update</a>
                                    <a href="delete_kontrak.php?id=<?= $row['id_pegawai'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contract?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <h2 class="mt-4"></h2>
                <button class="btn btn-primary mb-3" onclick="window.location.href='submit_perubahan.php'">Tambah Perubahan Kontrak Pegawai</button>
                <h2 class="mt-4">Daftar Perubahan Kontrak Pegawai</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Tanggal Perubahan</th>
                            <th>Gaji Sebelum Perubahan</th>
                            <th>Gaji Setelah Perubahan</th>
                            <th>Keterangan Perubahan</th>
                            <th>Edit Riwayat Perubahan</th>
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
                                <td>
                                <a href="edit_perubahan.php?id=<?= $row['id'] ?>" class="btn btn-warning">Update</a>
                                <a href="delete_perubahan.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contract?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="dokumen" role="tabpanel" aria-labelledby="dokumen-tab">
                <h2 class="mt-4"></h2>
                <button class="btn btn-primary mb-3" onclick="window.location.href='submit_dokumen.php'">Tambah Dokumen Pendukung</button>
                <h2 class="mt-4">Daftar Dokumen Pendukung</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Dokumen Pegawai</th>
                            <th>Kontrak Pegawai</th>
                            <th>Jenis Dokumen</th>
                            <th>Tanggal Unggah</th>
                            <th>Keterangan</th>
                            <th>Nama File</th>
                            <th>Edit Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><?= $doc['dokumen_peg'] ?></td>
                                <td><?= $doc['kontrak_peg'] ?></td>
                                <td><?= $doc['jenis_dokumen'] ?></td>
                                <td><?= $doc['tanggal_unggah'] ?></td>
                                <td><?= $doc['nama_file'] ?></td>
                                <td><?= $doc['lokasi_file'] ?></td>                            
                                <td>
                                <a href="edit_dokumen.php?id=<?= $doc['dokumen_peg'] ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_dokumen.php?id=<?= $doc['dokumen_peg'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this document?');">Delete</a>
                                </td>
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
