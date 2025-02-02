<?php
include '../template/header.php';
include '../template/sidebar.php';
include 'koneksi.php';

// Koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "hris");
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Pastikan kolom id_mutasi ada di tabel mutasi jika belum ada
$check_column = $mysqli->query("SHOW COLUMNS FROM mutasi LIKE 'id_mutasi'");
if ($check_column->num_rows == 0) {
    $mysqli->query("ALTER TABLE mutasi ADD COLUMN id_mutasi INT AUTO_INCREMENT PRIMARY KEY") or die($mysqli->error);
}

// Variabel pesan
$message = "";
$message_type = "";

// Konfigurasi pagination
$per_page = 2; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;

// Proses pencarian
$search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
$where = '';
if (!empty($search)) {
    $where = " WHERE 
        id_pegawai LIKE '%$search%' OR 
        jbt_lama LIKE '%$search%' OR 
        jbt_baru LIKE '%$search%' OR 
        dpm_lama LIKE '%$search%' OR 
        dpm_baru LIKE '%$search%' OR 
        alasan_mutasi LIKE '%$search%'";
}

// Update query total data dengan kondisi pencarian
$total_query = "SELECT COUNT(*) as total FROM mutasi" . $where;
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $per_page);

// Update query data dengan kondisi pencarian
$sql = "SELECT * FROM mutasi" . $where . " LIMIT $start, $per_page";
$result = $mysqli->query($sql);

// Proses tambah, edit, atau hapus data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pegawai = filter_input(INPUT_POST, 'id_pegawai', FILTER_SANITIZE_NUMBER_INT);
    $jbt_lama = filter_input(INPUT_POST, 'jbt_lama', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $jbt_baru = filter_input(INPUT_POST, 'jbt_baru', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dpm_lama = filter_input(INPUT_POST, 'dpm_lama', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dpm_baru = filter_input(INPUT_POST, 'dpm_baru', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tgl_mutasi = $_POST['tgl_mutasi'];
    $alasan_mutasi = filter_input(INPUT_POST, 'alasan_mutasi', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $status_mutasi = filter_input(INPUT_POST, 'status_mutasi', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validate input fields
    if (empty($id_pegawai) || empty($jbt_lama) || empty($jbt_baru) || empty($dpm_lama) || empty($dpm_baru) || empty($tgl_mutasi) || empty($alasan_mutasi) || empty($status_mutasi)) {
        $message = "Semua field harus diisi.";
        $message_type = "error";
    } else {
        if (!empty($_POST['edit_id'])) {
            // Edit data
            $edit_id = (int) $_POST['edit_id'];
            $stmt = $mysqli->prepare("UPDATE mutasi SET id_pegawai = ?, jbt_lama = ?, jbt_baru = ?, dpm_lama = ?, dpm_baru = ?, tgl_mutasi = ?, alasan_mutasi = ?, status_mutasi = ? WHERE id_mutasi = ?");
            $stmt->bind_param("isssssssi", $id_pegawai, $jbt_lama, $jbt_baru, $dpm_lama, $dpm_baru, $tgl_mutasi, $alasan_mutasi, $status_mutasi, $edit_id);
        } else {
            // Insert new data
            $stmt = $mysqli->prepare("INSERT INTO mutasi (id_pegawai, jbt_lama, jbt_baru, dpm_lama, dpm_baru, tgl_mutasi, alasan_mutasi, status_mutasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $id_pegawai, $jbt_lama, $jbt_baru, $dpm_lama, $dpm_baru, $tgl_mutasi, $alasan_mutasi, $status_mutasi);
        }

        if ($stmt->execute()) {
            $message = "Data berhasil disimpan.";
            $message_type = "success";
        } else {
            $message = "Gagal menyimpan data: " . $stmt->error;
            $message_type = "error";
        }
        $stmt->close();
    }
} elseif (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];
    $stmt = $mysqli->prepare("DELETE FROM mutasi WHERE id_mutasi = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Data berhasil dihapus.";
        $message_type = "success";
    } else {
        $message = "Gagal menghapus data: " . $stmt->error;
        $message_type = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Promosi & Mutasi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap CDN for responsive design -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-fluid {
            display: flex;
            margin-left: 0;
        }

        .sidebar {
            width: 250px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary { background: #007bff; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; color: white; }
        
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="sidebar">
            <?php include '../template/sidebar.php'; ?>
        </div>
        <div class="main-content">
            <h2 class="mb-3">Daftar Promosi & Mutasi</h2>
            
            <!-- Tombol untuk menambah data -->
            <button class="btn btn-primary mb-3" data-toggle="collapse" data-target="#addForm">Tambah Data</button>
            
            <!-- Form pencarian dipindah ke sini -->
            <div class="card mb-3">
                <div class="card-body">
                    <form class="d-flex" method="GET">
                        <input class="form-control me-2" type="search" name="search" 
                               placeholder="Cari data mutasi..." 
                               value="<?= htmlspecialchars($search) ?>" 
                               aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                        <?php if (!empty($search)): ?>
                            <a href="?" class="btn btn-outline-secondary ms-2">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <?php if (!empty($search)): ?>
                <div class="alert alert-info">
                    Menampilkan hasil pencarian untuk: "<?= htmlspecialchars($search) ?>"
                    <?php if ($total_row['total'] > 0): ?>
                        (<?= $total_row['total'] ?> hasil)
                    <?php else: ?>
                        (Tidak ada hasil)
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($message): ?>
                <div class="alert <?= $message_type === 'success' ? 'alert-success' : 'alert-danger' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Form untuk menambah data yang disembunyikan pada awalnya -->
            <div id="addForm" class="collapse form-container">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="id_pegawai">ID Pegawai:</label>
                        <input type="number" class="form-control" name="id_pegawai" id="id_pegawai" required>
                    </div>
                    <div class="form-group">
                        <label for="jbt_lama">Jabatan Lama:</label>
                        <input type="text" class="form-control" name="jbt_lama" id="jbt_lama" required>
                    </div>
                    <div class="form-group">
                        <label for="jbt_baru">Jabatan Baru:</label>
                        <input type="text" class="form-control" name="jbt_baru" id="jbt_baru" required>
                    </div>
                    <div class="form-group">
                        <label for="dpm_lama">Departemen Lama:</label>
                        <input type="text" class="form-control" name="dpm_lama" id="dpm_lama" required>
                    </div>
                    <div class="form-group">
                        <label for="dpm_baru">Departemen Baru:</label>
                        <input type="text" class="form-control" name="dpm_baru" id="dpm_baru" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_mutasi">Tanggal Mutasi:</label>
                        <input type="date" class="form-control" name="tgl_mutasi" id="tgl_mutasi" required>
                    </div>
                    <div class="form-group">
                        <label for="alasan_mutasi">Alasan Mutasi:</label>
                        <input type="text" class="form-control" name="alasan_mutasi" id="alasan_mutasi" required>
                    </div>
                    <div class="form-group">
                        <label for="status_mutasi">Status Mutasi:</label>
                        <input type="text" class="form-control" name="status_mutasi" id="status_mutasi" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>

            <?php
                // Jika ada edit_id, ambil data dari database untuk diedit
                if (isset($_GET['edit_id'])) {
                    $edit_id = (int) $_GET['edit_id'];
                    $stmt = $mysqli->prepare("SELECT * FROM mutasi WHERE id_mutasi = ?");
                    $stmt->bind_param("i", $edit_id);
                    $stmt->execute();
                    $result_edit = $stmt->get_result();
                    $edit_data = $result_edit->fetch_assoc();
                    $stmt->close();
                }
            ?>

            <!-- Form Edit Data -->
            <?php if (isset($edit_data)): ?>
            <div class="form-container">
                <form action="" method="post">
                    <input type="hidden" name="edit_id" value="<?= $edit_data['id_mutasi'] ?>">
                    <div class="form-group">
                        <label for="id_pegawai">ID Pegawai:</label>
                        <input type="number" class="form-control" name="id_pegawai" value="<?= $edit_data['id_pegawai'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jbt_lama">Jabatan Lama:</label>
                        <input type="text" class="form-control" name="jbt_lama" value="<?= $edit_data['jbt_lama'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jbt_baru">Jabatan Baru:</label>
                        <input type="text" class="form-control" name="jbt_baru" value="<?= $edit_data['jbt_baru'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dpm_lama">Departemen Lama:</label>
                        <input type="text" class="form-control" name="dpm_lama" value="<?= $edit_data['dpm_lama'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dpm_baru">Departemen Baru:</label>
                        <input type="text" class="form-control" name="dpm_baru" value="<?= $edit_data['dpm_baru'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_mutasi">Tanggal Mutasi:</label>
                        <input type="date" class="form-control" name="tgl_mutasi" value="<?= $edit_data['tgl_mutasi'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alasan_mutasi">Alasan Mutasi:</label>
                        <input type="text" class="form-control" name="alasan_mutasi" value="<?= $edit_data['alasan_mutasi'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status_mutasi">Status Mutasi:</label>
                        <input type="text" class="form-control" name="status_mutasi" value="<?= $edit_data['status_mutasi'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Perbarui Data</button>
                </form>
            </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pegawai</th>
                            <th>Jabatan Lama</th>
                            <th>Jabatan Baru</th>
                            <th>Departemen Lama</th>
                            <th>Departemen Baru</th>
                            <th>Tanggal Promosi</th>
                            <th>Alasan Promosi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id_pegawai']) ?></td>
                                <td><?= htmlspecialchars($row['jbt_lama']) ?></td>
                                <td><?= htmlspecialchars($row['jbt_baru']) ?></td>
                                <td><?= htmlspecialchars($row['dpm_lama']) ?></td>
                                <td><?= htmlspecialchars($row['dpm_baru']) ?></td>
                                <td><?= htmlspecialchars($row['tgl_mutasi']) ?></td>
                                <td><?= htmlspecialchars($row['alasan_mutasi']) ?></td>
                                <td>
                                    <a href="?edit_id=<?= $row['id_mutasi'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="?delete_id=<?= $row['id_mutasi'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" 
                           <?= ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Previous</a>
                    </li>
                    
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>"
                           <?= ($page >= $total_pages) ? 'tabindex="-1" aria-disabled="true"' : '' ?>>Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
