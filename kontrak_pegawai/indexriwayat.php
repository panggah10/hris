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
        <h1>Riwayat Perubahan Kontrak Pegawai</h1>
        <ul class="nav nav-tabs" id="kontrakPegawaiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="riwayat-tab" data-bs-toggle="tab" href="#riwayat" role="tab" aria-controls="riwayat" aria-selected="true">Riwayat Perubahan</a>
            </li>
        </ul>
        <div class="tab-content" id="kontrakPegawaiTabContent">
            <div class="tab-pane fade show active" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                <h2>Riwayat Perubahan</h2>
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
                    <button type="submit" class="btn btn-primary">Log Perubahan</button>
                </form>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>ID Kontrak</th>
                            <th>Tanggal Perubahan</th>
                            <th>Gaji Sebelum Perubahan</th>
                            <th>Gaji Setelah Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($change_history as $row): ?>
                            <tr>
                                <td><?= $row['id_kontrak'] ?></td>
                                <td><?= $row['tanggal_perubahan'] ?></td>
                                <td><?= $row['gaji_sebelum_perubahan'] ?></td>
                                <td><?= $row['gaji_setelah_perubahan'] ?></td>
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
