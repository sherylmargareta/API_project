<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Periksa apakah parameter id disertakan dalam URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Ambil nilai id dari parameter URL
        $id = $_GET['id'];

        // Persiapkan dan jalankan query DELETE
        $sql = "DELETE FROM input WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Data berhasil dihapus.");window.location="list.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Parameter ID tidak valid.";
    }
}