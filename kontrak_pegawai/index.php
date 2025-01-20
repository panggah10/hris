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
?>
<main id="main" class="main">
    <div class="container">
        <h1>Fitur Kontrak Pegawai</h1>
        <ul class="nav nav-tabs" id="kontrakPegawaiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="kontrak-tab" data-bs-toggle="tab" href="#kontrak" role="tab" aria-controls="kontrak" aria-selected="true">Data Kontrak Pegawai</a>
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
                        <input type="text" class="form-control" id="tipe_kontrak" name="tipe_kontrak" required>
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
                                <td><?= $row['tanggal_mulai'] ?></td>
                                <td><?= $row['tanggal_berakhir'] ?></td>
                                <td><?= $row['status_kontrak'] ?></td>
                                <td><?= $row['gaji_bulanan'] ?></td>
                                <td><?= $row['tipe_kontrak'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<?php
include '../template/footer.php';
?>
