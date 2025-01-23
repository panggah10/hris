<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching data from the form
    $id_pegawai = $_POST['id_pegawai'];
    $tanggal_mulai_kontrak = date('Y-m-d', strtotime($_POST['tanggal_mulai_kontrak']));
    $tanggal_berakhir_kontrak = date('Y-m-d', strtotime($_POST['tanggal_berakhir_kontrak']));
    $status_kontrak = $_POST['status_kontrak'];
    $gaji_bulanan = $_POST['gaji_bulanan'];
    $tipe_kontrak = $_POST['tipe_kontrak'];
    $tanggal_perubahan = date('Y-m-d'); // Assuming today's date for the change

    // Fetch the current salary before the update
    $current_salary_query = "SELECT gaji_bulanan FROM `kontrak pegawai` WHERE id_pegawai = '$id_pegawai' ORDER BY tanggal_berakhir_kontrak DESC LIMIT 1";
    $current_salary_result = $conn->query($current_salary_query);
    $current_salary_row = $current_salary_result->fetch_assoc();
    $gaji_sebelum_perubahan = $current_salary_row ? $current_salary_row['gaji_bulanan'] : 0;

    // Insert the contract data into the database
    $query = "INSERT INTO `kontrak pegawai` (id_pegawai, tanggal_mulai_kontrak, tanggal_berakhir_kontrak, status_kontrak, gaji_bulanan, tipe_kontrak) VALUES ('$id_pegawai', '$tanggal_mulai_kontrak', '$tanggal_berakhir_kontrak', '$status_kontrak', '$gaji_bulanan', '$tipe_kontrak')";
    $conn->query($query);

    // Fetch the next id_perubahan
    $max_id_query = "SELECT MAX(id_perubahan) AS max_id FROM `riwayat perubahan kontrak`";
    $max_id_result = $conn->query($max_id_query);
    $max_id_row = $max_id_result->fetch_assoc();
    $new_id_perubahan = $max_id_row['max_id'] + 1;

    // Log the change in the change_history table
    $log_query = "INSERT INTO `riwayat perubahan kontrak` (id_perubahan, id_kontrak, tanggal_perubahan, gaji_sebelum_perubahan, gaji_setelah_perubahan, keterangan_perubahan) VALUES ('$new_id_perubahan', '$id_pegawai', '$tanggal_perubahan', '$gaji_sebelum_perubahan', '$gaji_bulanan', 'Update kontrak')";
    $conn->query($log_query);

    // Redirect or display a success message
    header("Location: index.php");
    exit();
}
?>
