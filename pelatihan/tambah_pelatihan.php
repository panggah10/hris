<?php
require_once 'koneksi.php';

// Inisialisasi pesan
$error = '';
$success = '';

// Proses form jika ada POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Siapkan query
        $query = "INSERT INTO pelatihan (
            nama_pelatihan,
            deskripsi_pelatihan,
            tgl_pelatihan,
            jam_pelatihan,
            durasi_pelatihan,
            lokasi_pelatihan,
            pemateri_pelatihan,
            id_peg,
            kapasitas,
            status_pelatihan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            // Bind parameter
            $id_peg = !empty($_POST['id_peg']) ? $_POST['id_peg'] : null;
            
            $stmt->bind_param("ssssssssss",
                $_POST['nama_pelatihan'],
                $_POST['deskripsi_pelatihan'],
                $_POST['tgl_pelatihan'],
                $_POST['jam_pelatihan'],
                $_POST['durasi_pelatihan'],
                $_POST['lokasi_pelatihan'],
                $_POST['pemateri_pelatihan'],
                $id_peg,
                $_POST['kapasitas'],
                $_POST['status_pelatihan']
            );

            // Eksekusi query
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Gagal menambahkan data";
            }
            $stmt->close();
        } else {
            $error = "Gagal mempersiapkan query";
        }
    } catch (Exception $e) {
        $error = "Gagal menambahkan data";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelatihan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-wrapper {
            margin-left: 260px;
            margin-top: 70px;
            padding: 15px 25px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah Pelatihan Baru</h5>
                </div>
                <div class="card-body">
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Pelatihan</label>
                                <input type="text" name="nama_pelatihan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Deskripsi Pelatihan</label>
                                <input type="text" name="deskripsi_pelatihan" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Pelatihan</label>
                                <input type="date" name="tgl_pelatihan" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jam Pelatihan</label>
                                <input type="time" name="jam_pelatihan" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Durasi Pelatihan</label>
                                <input type="text" name="durasi_pelatihan" class="form-control" placeholder="Contoh: 3 Jam" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Pelatihan</label>
                                <input type="text" name="lokasi_pelatihan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pemateri Pelatihan</label>
                                <input type="text" name="pemateri_pelatihan" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Status Pelatihan</label>
                                <select name="status_pelatihan" class="form-select" required>
                                    <option value="Belum Terlaksana">Belum Terlaksana</option>
                                    <option value="Terlaksana">Terlaksana</option>
                                    <option value="Gagal Terlaksana">Gagal Terlaksana</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ID Pegawai</label>
                                <input type="number" name="id_peg" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kapasitas</label>
                                <input type="text" name="kapasitas" class="form-control" placeholder="Contoh: 30 Orang" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 