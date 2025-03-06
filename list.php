<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DebtPaying - List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

        <a href="home.html" class="btn btn-outline-primary btn-sm float-end">Home</a>
        <h2 class="text-center">DebtPaying - List Mitra</h2>
        <br>
        <div class="container" align="text-center">
            <?php
            include('conn.php');

            // Query untuk mendapatkan data dari database
            $sql = "SELECT * FROM input";
            $result = $conn->query($sql);

            // Tampilkan hasil query dalam tabel Bootstrap
            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Invoice Name</th>';
                echo '<th>Invoice ID</th>';
                echo '<th>Name</th>';
                echo '<th>E-Mail</th>';
                echo '<th>HP</th>';
                echo '<th>Catatan</th>';
                echo '<th>Subtotal</th>';
                echo '<th>Waktu</th>';
                '<th class="hide-item">Item</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['invoice'] . '</td>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['phone'] . '</td>';
                    echo '<td>' . $row['cat'] . '</td>';
                    echo '<td>' . $row['subtotal'] . '</td>';
                    echo '<td>' . $row['time'] . '</td>';
                    echo '<td>
                        <a href="main.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Checkout</a>
                        <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Delete</a>
                          </td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo "Tidak ada data dalam database.";
            }

            // Tutup koneksi
            $conn->close();
            ?>
        </div>
    </div>
</div>
 </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
