<?php
include '../template/header.php';
include '../template/sidebar.php';
include 'koneksi.php';

// Fungsi untuk memperbarui data promosi
if (isset($_POST['edit'])) {
    $id_peg = $_POST['id_peg'];
    $jab_lama = $_POST['jab_lama'];
    $jab_baru = $_POST['jab_baru'];
    $tgl_promosi = $_POST['tgl_promosi'];
    $alasan_promosi = $_POST['alasan_promosi'];

    $query = "UPDATE promosi SET jab_lama = ?, jab_baru = ?, tgl_promosi = ?, alasan_promosi = ? WHERE id_peg = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $jab_lama, $jab_baru, $tgl_promosi, $alasan_promosi, $id_peg);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Data promosi berhasil diperbarui!";
        header("Location: promosi.php"); // Redirect setelah update
        exit();
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fungsi untuk menghapus data promosi
if (isset($_GET['delete'])) {
    $id_peg = $_GET['delete'];

    $query = "DELETE FROM promosi WHERE id_peg = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_peg);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Data promosi berhasil dihapus!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Konfigurasi pagination
$per_page = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

// Query untuk mendapatkan total data
$total_query = "SELECT COUNT(*) as total FROM promosi";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $per_page);

// Query dengan limit untuk pagination
$query = "SELECT * FROM promosi LIMIT $start, $per_page";
$result = mysqli_query($conn, $query);

// If 'edit' parameter is set, fetch the data for the modal form
$editData = null;
if (isset($_GET['edit'])) {
    $id_peg = $_GET['edit'];
    $editQuery = "SELECT * FROM promosi WHERE id_peg = '$id_peg'";
    $editResult = mysqli_query($conn, $editQuery);
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRIS Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 5;
            left: 5;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #f1f1f1;
            color: #007bff;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .action-links a {
            margin-right: 10px;
        }

        .modal-body input, .modal-body textarea {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <?php include '../template/sidebar.php'; ?>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <div class="container">
            <h1 class="text-center mb-3">Manajemen Promosi Dan Mutasi</h1>

            <!-- Notifikasi -->
            <?php if (isset($message)): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <!-- Tabel Data Promosi -->
            <h2>Daftar Promosi&Mutasi</h2>
            <!-- Button for Adding New Data -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFormModal">Tambah Promosi</button>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Pegawai</th>
                        <th>Jabatan Lama</th>
                        <th>Jabatan Baru</th>
                        <th>Tanggal Promosi</th>
                        <th>Alasan Promosi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id_peg'] ?></td>
                            <td><?= $row['jab_lama'] ?></td>
                            <td><?= $row['jab_baru'] ?></td>
                            <td><?= $row['tgl_promosi'] ?></td>
                            <td><?= $row['alasan_promosi'] ?></td>
                            <td class="action-links">
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm" 
                                   onclick="editPromosi('<?= $row['id_peg'] ?>', '<?= $row['jab_lama'] ?>', '<?= $row['jab_baru'] ?>', '<?= $row['tgl_promosi'] ?>', '<?= $row['alasan_promosi'] ?>')"
                                   data-bs-toggle="modal" data-bs-target="#editFormModal">
                                    Edit
                                </a>
                                <a href="?delete=<?= $row['id_peg'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Tombol Previous -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>" <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Previous</a>
                    </li>
                    
                    <!-- Nomor Halaman -->
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <!-- Tombol Next -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>" <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Modal for Adding New Data -->
        <div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFormModalLabel">Tambah Promosi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="id_peg" class="form-label">ID Pegawai</label>
                                <input type="text" class="form-control" name="id_peg" required>
                            </div>
                            <div class="mb-3">
                                <label for="jab_lama" class="form-label">Jabatan Lama</label>
                                <input type="text" class="form-control" name="jab_lama" required>
                            </div>
                            <div class="mb-3">
                                <label for="jab_baru" class="form-label">Jabatan Baru</label>
                                <input type="text" class="form-control" name="jab_baru" required>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_promosi" class="form-label">Tanggal Promosi</label>
                                <input type="date" class="form-control" name="tgl_promosi" required>
                            </div>
                            <div class="mb-3">
                                <label for="alasan_promosi" class="form-label">Alasan Promosi</label>
                                <textarea class="form-control" name="alasan_promosi" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="add">Tambah Promosi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editPromosi(id_peg, jab_lama, jab_baru, tgl_promosi, alasan_promosi) {
        document.querySelector('#editFormModal input[name="id_peg"]').value = id_peg;
        document.querySelector('#editFormModal input[name="jab_lama"]').value = jab_lama;
        document.querySelector('#editFormModal input[name="jab_baru"]').value = jab_baru;
        document.querySelector('#editFormModal input[name="tgl_promosi"]').value = tgl_promosi;
        document.querySelector('#editFormModal textarea[name="alasan_promosi"]').value = alasan_promosi;
    }
    </script>
</body>

</html>
