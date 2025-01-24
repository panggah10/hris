<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching data from the form
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal_mulai_kontrak = $_POST['tanggal_mulai_kontrak'];
    $tanggal_berakhir_kontrak = $_POST['tanggal_berakhir_kontrak'];
    $status_kontrak = $_POST['status_kontrak'];
    $gaji_bulanan = $_POST['gaji_bulanan'];
    $tipe_kontrak = $_POST['tipe_kontrak'];

    // Fetch the current salary before the update
    $current_salary_query = "SELECT gaji_bulanan FROM `kontrak pegawai` WHERE id_pegawai = '$id_pegawai' ORDER BY tanggal_berakhir DESC LIMIT 1";
    $current_salary_result = $conn->query($current_salary_query);
    $current_salary_row = $current_salary_result->fetch_assoc();
    $gaji_sebelum_perubahan = $current_salary_row ? $current_salary_row['gaji_bulanan'] : 0;

    // Insert the contract data into the database
    $query = "INSERT INTO `kontrak pegawai` (id_pegawai, tanggal_mulai, tanggal_berakhir, status_kontrak, gaji_bulanan, tipe_kontrak) VALUES ('$id_pegawai', '$tanggal_mulai_kontrak', '$tanggal_berakhir_kontrak', '$status_kontrak', '$gaji_bulanan', '$tipe_kontrak')";
    $conn->query($query);

    // Log the change in the change_history table
    $log_query = "INSERT INTO `riwayat perubahan kontrak` (id_kontrak, tanggal_perubahan, gaji_sebelum_perubahan, gaji_setelah_perubahan) VALUES ('$id_pegawai', NOW(), '$gaji_sebelum_perubahan', '$gaji_bulanan')";
    $conn->query($log_query);

    // Redirect or display a success message
    header("Location: index.php");
    exit();
}
?>
