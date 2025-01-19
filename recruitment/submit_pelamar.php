<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelamar = $_POST['id_pelamar'];

    // Lakukan sesuatu dengan ID pelamar, misalnya menyimpan ke database atau memproses lebih lanjut
    // Contoh: Menyimpan ID pelamar ke database
    $sql = "INSERT INTO pelamar (id_pelamar) VALUES ('$id_pelamar')";
    if ($conn->query($sql) === TRUE) {
        echo "ID pelamar berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>