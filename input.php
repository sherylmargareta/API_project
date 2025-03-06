<?php
include('conn.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari formulir
    $invoiceName = $_POST['invoiceName'];
    $referenceId = $_POST['referenceId'];
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPhone = $_POST['userPhone'];
    $remarks = $_POST['remarks'];
    $payAmount = $_POST['payAmount'];
    $expireTime = $_POST['expireTime'];

    // Mengonversi data item menjadi JSON
    $items = array();
    foreach ($_POST['itemName'] as $key => $itemName) {
        $itemType = $_POST['itemType'][$key];
        $itemCount = $_POST['itemCount'][$key];
        $itemTotalPrice = $_POST['itemTotalPrice'][$key];

        $items[] = array('name' => $itemName, 'type' => $itemType, 'count' => $itemCount, 'total_price' => $itemTotalPrice);
    }

    $itemsJson = json_encode($items);

    // Masukkan data ke dalam database
    $sql = "INSERT INTO input (invoice, id, name, email, phone, cat, subtotal, time, item) VALUES ('$invoiceName', '$referenceId', '$userName', '$userEmail', '$userPhone', '$remarks', '$payAmount', '$expireTime', '$itemsJson')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Data berhasil disimpan!");window.location="home.html";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DebtPaying - Input</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Table</title>
    <style>
        .item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .item input {
            flex: 1;
        }

        /* Optional styling for better presentation */
        #items-container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>

</head>
<body class="bg-light">

<div class="container mt-5">
            <a href="logout.php" class="btn btn-outline-danger btn-sm float-end">Logout</a>
        <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header" style="background-color: yellow;">
            <h2 class="text-center" style="color: black;">DebtPaying</h2>
            <h3 class="text-center" style="color: black;">Formulir Input Data Mitra</h3>

        </div>
        <div class="card-body">
            <form action="" method="post">
                <label for="invoiceName" class="form-label">Invoice Name:</label>
                <input type="text" name="invoiceName" class="form-control" required><br>

                <label for="referenceId" class="form-label">Reference ID:</label>
                <input type="text" name="referenceId" class="form-control" required><br>

                <label for="userName" class="form-label">Customer Name:</label>
                <input type="text" name="userName" class="form-control" required><br>

                <label for="userEmail" class="form-label">Customer Email:</label>
                <input type="email" name="userEmail" class="form-control" required><br>

                <label for="userPhone" class="form-label">Customer Phone:</label>
                <input type="tel" name="userPhone" class="form-control" required><br>

                <label for="remarks" class="form-label">Catatan:</label>
                <textarea name="remarks" class="form-control" required></textarea><br>

                <label for="payAmount" class="form-label">Subtotal:</label>
                <input type="number" name="payAmount" class="form-control" required><br>

                <label for="expireTime" class="form-label">Batas Waktu:</label>
                <input type="datetime-local" name="expireTime" class="form-control" required><br>

                 <label for="items" class="form-label">Items:</label>
                    <div id="items-container">
                        <!-- You can dynamically add items here using JavaScript -->
                        <div class="item">
                            <input type="text" name="itemName[]" class="form-control" placeholder="Keterangan" required>
                            <input type="hidden" name="itemType[]" value="ITEM" class="form-control" placeholder="Item Type" required>
                            <input type="number" name="itemCount[]" class="form-control" placeholder="Cicilan ke-" required>
                            <input type="number" name="itemTotalPrice[]" class="form-control" placeholder="Total" required>
                        </div>
                    </div>
                <button type="button" onclick="addNewItem()" class="btn btn-secondary mb-3">Add Item</button><br>
                <input type="submit" class="btn btn-primary" value="Submit Data">
            </form>
        </div>
      </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function addNewItem() {
        var itemsContainer = document.getElementById('items-container');
        var newItem = document.createElement('div');
        newItem.className = 'item mb-3';
        newItem.innerHTML = `
            <input type="text" name="itemName[]" class="form-control" placeholder="Keterangan" required>
            <input type="hidden" name="itemType[]" value="ITEM" class="form-control" placeholder="Item Type" required>
            <input type="number" name="itemCount[]" class="form-control" placeholder="Cicilan ke-" required>
            <input type="number" name="itemTotalPrice[]" class="form-control" placeholder="Total" required>
        `;
        itemsContainer.appendChild(newItem);
    }
</script>

</body>
</html>
