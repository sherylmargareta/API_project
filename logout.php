<?php
include('conn.php');

// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to the index or login page
// header("Location: index.php");
echo '<script>alert("Berhasil Log Out");window.location="index.php";</script>';
exit();
?>
