<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../recruitment/connection.php';
?>
<?php
// function getData is already defined, removing this duplicate

function getData($table) {
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Mendapatkan data dari tabel
$departemen = getData('departemen');
$jabatan = getData('jabatan');
$lowongan = getData('lowongan');
$pelamar = getData('pelamar');
$tahap_lamaran = getData('tahap_lamaran');
$penilaian_pelamar = getData('penilaian_pelamar');
?>
<main id="main" class="main">
<div class="container">
    <h1>Recruitment</h1>
    <ul class="nav nav-tabs" id="recruitmentTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="departemen-tab" data-bs-toggle="tab" href="#departemen" role="tab" aria-controls="departemen" aria-selected="true">Departemen</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="jabatan-tab" data-bs-toggle="tab" href="#jabatan" role="tab" aria-controls="jabatan" aria-selected="false">Jabatan</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="lowongan-tab" data-bs-toggle="tab" href="#lowongan" role="tab" aria-controls="lowongan" aria-selected="false">Lowongan</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="pelamar-tab" data-bs-toggle="tab" href="#pelamar" role="tab" aria-controls="pelamar" aria-selected="false">Pelamar</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tahap-lamaran-tab" data-bs-toggle="tab" href="#tahap-lamaran" role="tab" aria-controls="tahap-lamaran" aria-selected="false">Tahap Lamaran</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="penilaian-pelamar-tab" data-bs-toggle="tab" href="#penilaian-pelamar" role="tab" aria-controls="penilaian-pelamar" aria-selected="false">Penilaian Pelamar</a>
        </li>
    </ul>
    <div class="tab-content" id="recruitmentTabContent">
        <div class="tab-pane fade show active" id="departemen" role="tabpanel" aria-labelledby="departemen-tab">
            <h2>Departemen</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Departemen</th>
                        <th>Kepala Departemen</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departemen as $row): ?>
                        <tr>
                            <td><?= $row['id_departemen'] ?></td>
                            <td><?= $row['nama_departemen'] ?></td>
                            <td><?= $row['kepala_departemen'] ?></td>
                            <td><?= $row['lokasi_departemen'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="jabatan" role="tabpanel" aria-labelledby="jabatan-tab">
            <h2>Jabatan</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Jabatan</th>
                        <th>Deskripsi</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>ID Departemen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jabatan as $row): ?>
                        <tr>
                            <td><?= $row['id_jabatan'] ?></td>
                            <td><?= $row['nama_jabatan'] ?></td>
                            <td><?= $row['desk_jabatan'] ?></td>
                            <td><?= $row['level_jabatan'] ?></td>
                            <td><?= $row['status_jabatan'] ?></td>
                            <td><?= $row['id_departemen'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="lowongan" role="tabpanel" aria-labelledby="lowongan-tab">
            <h2>Lowongan</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lowongan</th>
                        <th>Deskripsi</th>
                        <th>ID Jabatan</th>
                        <th>Tanggal Posting</th>
                        <th>Tanggal Tutup</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowongan as $row): ?>
                        <tr>
                            <td><?= $row['id_lowongan'] ?></td>
                            <td><?= $row['nama_lowongan'] ?></td>
                            <td><?= $row['deskripsi_lowongan'] ?></td>
                            <td><?= $row['id_jabatan'] ?></td>
                            <td><?= $row['tgl_posting'] ?></td>
                            <td><?= $row['tgl_tutup'] ?></td>
                            <td><?= $row['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="pelamar" role="tabpanel" aria-labelledby="pelamar-tab">
            <h2>Pelamar</h2>
            <form method="post" action="submit_pelamar.php">
                <div class="mb-3">
                    <label for="id_pelamar" class="form-label">ID Pelamar</label>
                    <input type="text" class="form-control" id="id_pelamar" name="id_pelamar" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>ID Lowongan</th>
                        <th>Status</th>
                        <th>Jabatan Dipilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pelamar as $row): ?>
                        <tr>
                            <td><?= $row['id_pelamar'] ?></td>
                            <td><?= $row['nama_pel'] ?></td>
                            <td><?= $row['email_pel'] ?></td>
                            <td><?= $row['id_lowongan'] ?></td>
                            <td><?= $row['status_pel'] ?></td>
                            <td><?= $row['jabatan_dipilih'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tahap-lamaran" role="tabpanel" aria-labelledby="tahap-lamaran-tab">
            <h2>Tahap Lamaran</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Tahap</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tahap_lamaran as $row): ?>
                        <tr>
                            <td><?= $row['id_tahap'] ?></td>
                            <td><?= $row['nama_tahap'] ?></td>
                            <td><?= $row['deskripsi_tahap'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="penilaian-pelamar" role="tabpanel" aria-labelledby="penilaian-pelamar-tab">
            <h2>Penilaian Pelamar</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Pelamar</th>
                        <th>ID Tahap</th>
                        <th>Tanggal Dinilai</th>
                        <th>Skor</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($penilaian_pelamar as $row): ?>
                        <tr>
                            <td><?= $row['id_penilaian_pel'] ?></td>
                            <td><?= $row['id_pelamar'] ?></td>
                            <td><?= $row['id_tahap'] ?></td>
                            <td><?= $row['tgl_dinilai'] ?></td>
                            <td><?= $row['skor'] ?></td>
                            <td><?= $row['catatan'] ?></td>
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