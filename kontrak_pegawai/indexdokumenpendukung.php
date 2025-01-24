<?php
include '../template/header.php';
include '../template/sidebar.php';
include '../connection.php';

// Function to retrieve existing contracts
function getContracts() {
    global $conn;
    $sql = "SELECT * FROM `dokumen pendukung`";
    $result = $conn->query($sql);
    return $result;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetching data from the form
    $dokumen_peg = $_POST['dokumen_peg'];
    $kontrak_peg = $_POST['kontrak_peg'];
    $jenis_dokumen = $_POST['jenis_dokumen'];
    $tanggal_unggah = $_POST['tanggal_unggah'];
    $nama_file = $_FILES['nama_file']['name'];
    $lokasi_file = $_POST['lokasi_file'];

    // File upload logic
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["nama_file"]["name"]);
    move_uploaded_file($_FILES["nama_file"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO `dokumen pendukung` (dokumen_peg, kontrak_peg, jenis_dokumen, tanggal_unggah, nama_file, lokasi_file) VALUES ('$dokumen_peg', '$kontrak_peg', '$jenis_dokumen', '$tanggal_unggah', '$nama_file', '$lokasi_file')";
    $conn->query($sql);
}

// Fetch existing contracts
$contracts = getContracts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dokumen Pendukung</title>
</head>
<body>
    <h1>Upload Employee Contract</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="dokumen_peg">Dokumen Pegawai:</label>
        <input type="number" name="dokumen_peg" required><br>

        <label for="kontrak_peg">Kontrak Pegawai:</label>
        <input type="number" name="kontrak_peg" required><br>

        <label for="jenis_dokumen">Jenis Dokumen:</label>
        <input type="number" name="jenis_dokumen" required><br>

        <label for="tanggal_unggah">Tanggal Unggah:</label>
        <input type="date" name="tanggal_unggah" required><br>

        <label for="nama_file">Nama File:</label>
        <input type="file" name="nama_file" required><br>

        <label for="lokasi_file">Lokasi File:</label>
        <input type="number" name="lokasi_file" required><br>

        <input type="submit" value="Upload">
    </form>

    <h2>Existing Contracts</h2>
    <table>
        <tr>
            <th>Dokumen Pegawai</th>
            <th>Kontrak Pegawai</th>
            <th>Jenis Dokumen</th>
            <th>Tanggal Unggah</th>
            <th>Nama File</th>
            <th>Lokasi File</th>
        </tr>
        <?php while ($row = $contracts->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['dokumen_peg']; ?></td>
            <td><?php echo $row['kontrak_peg']; ?></td>
            <td><?php echo $row['jenis_dokumen']; ?></td>
            <td><?php echo $row['tanggal_unggah']; ?></td>
            <td><?php echo $row['nama_file']; ?></td>
            <td><?php echo $row['lokasi_file']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
