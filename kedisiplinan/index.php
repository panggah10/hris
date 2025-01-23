<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';
?>

<?php




// Proses Tambah Data
if (isset($_POST['tambah'])) {
    $id_peg = $_POST['id_peg'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $sanksi = $_POST['sanksi'];

    $query = "INSERT INTO kedisiplinan (id_peg, jenis_pelanggaran, sanksi)
              VALUES ('$id_peg', '$jenis_pelanggaran', '$sanksi')";
    if ($connection->query($query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $connection->error;
    }
}

// Proses Update Data
if (isset($_POST['update'])) {
    $id_kedisiplinan = $_POST['id_kedisiplinan'];
    $id_peg = $_POST['id_peg'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $sanksi = $_POST['sanksi'];

    $query = "UPDATE kedisiplinan 
              SET id_peg='$id_peg', jenis_pelanggaran='$jenis_pelanggaran', sanksi='$sanksi'
              WHERE id_kedisiplinan='$id_kedisiplinan'";
    if ($connection->query($query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $connection->error;
    }
}

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $id_kedisiplinan = $_GET['hapus'];

    $query = "DELETE FROM kedisiplinan WHERE id_kedisiplinan='$id_kedisiplinan'";
    if ($connection->query($query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $connection->error;
    }
}

// Ambil data edit
$data_edit = null;
if (isset($_GET['edit'])) {
    $id_kedisiplinan = $_GET['edit'];
    $query_edit = "SELECT * FROM kedisiplinan WHERE id_kedisiplinan='$id_kedisiplinan'";
    $result_edit = $connection->query($query_edit);
    $data_edit = $result_edit->fetch_assoc();
}
?>

<main id="main" class="main">
    <div class="container">
        <h1>Manajemen Kedisiplinan Pegawai</h1>

        <!-- Form Tambah/Edit -->
        <h2><?= isset($data_edit) ? 'Edit Data' : 'Tambah Data' ?></h2>
        <form method="POST">
            <input type="hidden" name="id_kedisiplinan" value="<?= $data_edit['id_kedisiplinan'] ?? '' ?>">
            <label for="id_peg">Pegawai:</label>
            <select name="id_peg" required>
                <option value="">Pilih Pegawai</option>
                <?php foreach ($pegawai as $p): ?>
                    <option value="<?= $p['id_peg'] ?>" <?= (isset($data_edit) && $data_edit['id_peg'] == $p['id_peg']) ? 'selected' : '' ?>>
                        <?= $p['nama_pegawai'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label for="jenis_pelanggaran">Jenis Pelanggaran:</label>
            <input type="text" name="jenis_pelanggaran" value="<?= $data_edit['jenis_pelanggaran'] ?? '' ?>" required><br>
            <label for="sanksi">Sanksi:</label>
            <input type="text" name="sanksi" value="<?= $data_edit['sanksi'] ?? '' ?>" required><br>
            <button type="submit" name="<?= isset($data_edit) ? 'update' : 'tambah' ?>">
                <?= isset($data_edit) ? 'Update' : 'Tambah' ?>
            </button>
        </form>

        <!-- Tabel Data -->
        <h2>Daftar Kedisiplinan</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Sanksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kedisiplinan as $row): ?>
                    <tr>
                        <td><?= $row['id_kedisiplinan'] ?></td>
                        <td><?= $row['nama_pegawai'] ?></td>
                        <td><?= $row['jenis_pelanggaran'] ?></td>
                        <td><?= $row['sanksi'] ?></td>
                        <td>
                            <a href="index.php?edit=<?= $row['id_kedisiplinan'] ?>">Edit</a>
                            <a href="index.php?hapus=<?= $row['id_kedisiplinan'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include '../template/footer.php';
?>
