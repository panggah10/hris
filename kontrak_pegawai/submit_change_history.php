<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching data from the form
    $id_kontrak = $_POST['id_kontrak'];
    $tanggal_perubahan = $_POST['tanggal_perubahan'];
    $gaji_sebelum_perubahan = $_POST['gaji_sebelum_perubahan']; // Ensure this matches the form input name
    $gaji_setelah_perubahan = $_POST['gaji_setelah_perubahan']; // Ensure this matches the form input name
    $keterangan_perubahan = $_POST['keterangan_perubahan'];

    // Fetch the next id_perubahan
    $max_id_query = "SELECT MAX(id_perubahan) AS max_id FROM `riwayat perubahan kontrak`";
    $max_id_result = $conn->query($max_id_query);
    $max_id_row = $max_id_result->fetch_assoc();
    $new_id_perubahan = $max_id_row['max_id'] + 1;

    // Log the change in the change_history table
    $log_query = "INSERT INTO `riwayat perubahan kontrak` (id_perubahan, id_kontrak, tanggal_perubahan, gaji_sebelum_perubahan, gaji_setelah_perubahan, keterangan_perubahan) VALUES ('$new_id_perubahan', '$id_kontrak', '$tanggal_perubahan', '$gaji_sebelum_perubahan', '$gaji_setelah_perubahan', '$keterangan_perubahan')";
    $conn->query($log_query);

    // Redirect or display a success message
    header("Location: index.php");
    exit();
}
?>
