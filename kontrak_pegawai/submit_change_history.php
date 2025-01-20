<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching data from the form
    $id_kontrak = $_POST['id_kontrak'];
    $gaji_sebelum_perubahan = $_POST['gaji_sebelum']; // Ensure this matches the form input name
    $gaji_setelah_perubahan = $_POST['gaji_setelah']; // Ensure this matches the form input name

    // Log the change in the change_history table
    $log_query = "INSERT INTO `riwayat perubahan kontrak` (id_kontrak, tanggal_perubahan, gaji_sebelum_perubahan, gaji_setelah_perubahan) VALUES ('$id_kontrak', NOW(), '$gaji_sebelum_perubahan', '$gaji_setelah_perubahan')";
    $conn->query($log_query);

    // Redirect or display a success message
    header("Location: index.php");
    exit();
}
?>
