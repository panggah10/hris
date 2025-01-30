<?php
include '../connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("ID not provided.");
}

// Prepare and execute the delete statement
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM `kontrak pegawai` WHERE `id_pegawai` = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirect to index.php after successful deletion
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
