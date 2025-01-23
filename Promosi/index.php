<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';
?>
</php>

function getData($table)
{
global $conn;
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
return $result->fetch_all(MYSQLI_ASSOC);
}
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Promosi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Promosi</li>
                <section class="section dashboard">
                    <div class="row">
                        <form class="row g-3 needs-validation" novalidate method="POST" action="proses_mutasi.php">
                            <div class="col-12">
                                <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                                <select class="form-select" id="karyawan_id" name="karyawan_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    <!-- Ambil data karyawan dari database -->
                                    <?php
                                    // Contoh data karyawan, ganti dengan query database Anda
                                    $karyawan = [
                                        ['id' => 1, 'nama' => 'Mufli'],
                                        ['id' => 2, 'nama' => 'Sadam'],
                                        ['id' => 3, 'nama' => 'Azam'],
                                    ];

                                    foreach ($karyawan as $k) {
                                        echo "<option value='{$k['id']}'>{$k['nama']}</option>";
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Silakan pilih posisi lama.</div>
                            </div>

                            <div class="invalid-feedback">Silakan pilih posisi lama.</div>
                    </div>

                    <label for="posisi_id" class="form-label">Pilih posisi lama</label>
                    <select class="form-select" id="posisi_id" name="posisi_id" required>
                        <option value="">Pilih posisi lama</option>
                        <!-- Ambil data posisi dari database -->
                        <?php
                        // Contoh data karyawan, ganti dengan query database Anda
                        $karyawan = [
                            ['id' => 1, 'posisi' => 'HRD'],
                            ['id' => 2, 'posisi' => 'KEUANGAN'],
                            ['id' => 3, 'posisi' => 'PROMOSI'],
                        ];

                        foreach ($karyawan as $k) {
                            echo "<option value='{$k['id']}'>{$k['posisi']}</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Silakan pilih posisi baru.</div>
    </div>

    <label for="posisi_id" class="form-label">Pilih posisi baru</label>
    <select class="form-select" id="posisi_id" name="posisi_id" required>
        <option value="">Pilih posisi baru</option>
        <!-- Ambil data posisi dari database -->
        <?php
        // Contoh data karyawan, ganti dengan query database Anda
        $karyawan = [
            ['id' => 1, 'posisi' => 'HRD'],
            ['id' => 2, 'posisi' => 'KEUANGAN'],
            ['id' => 3, 'posisi' => 'PROMOSI'],
        ];

        foreach ($karyawan as $k) {
            echo "<option value='{$k['id']}'>{$k['posisi']}</option>";
        }
        ?>
    </select>
    <div class="invalid-feedback">Silakan pilih posisi baru.</div>
    </div>

    <div class="col-12">
        <label for="alasan_mutasi" class="form-label">Alasan Mutasi</label>
        <textarea class="form-control" id="alasan_mutasi" name="alasan_mutasi" rows="3" required></textarea>
        <div class="invalid-feedback">Silakan masukkan alasan mutasi.</div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Ajukan Mutasi</button>
    </div>
    </form>
    </div>
    </section>
</main><!-- End #main -->
</ol>
</nav>
</div><!-- End Page Title -->

<?php
include '../template/footer.php';
?>