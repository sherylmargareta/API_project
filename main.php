<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Periksa apakah parameter id disertakan dalam URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Ambil nilai id dari parameter URL
        $id = $_GET['id'];

        // Persiapkan dan jalankan query SELECT untuk mendapatkan data berdasarkan ID
        $sql = "SELECT * FROM input WHERE id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DebtPaying - Edit Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <a href="home.html" class="btn btn-outline-primary btn-sm float-end">Home</a>
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header" style="background-color: purple;">
            <h2 class="text-center" style="color: white;">DebtPaying</h2>
            <h3 class="text-center" style="color: white;">Checkout Invoice</h3>
        </div>
        <div class="card-body">
            <form action="process_invoice.php" method="post">
                <!-- Include the ID as a hidden input field -->
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                <label for="invoiceName" class="form-label">Invoice Name:</label>
                <input type="text" name="invoiceName" class="form-control" value="<?php echo $row['invoice']; ?>" required><br>

                <label for="referenceId" class="form-label">Reference ID:</label>
                <input type="text" name="referenceId" class="form-control" value="<?php echo $row['id']; ?>" required><br>

                <label for="userName" class="form-label">Customer Name:</label>
                <input type="text" name="userName" class="form-control" value="<?php echo $row['name']; ?>" required><br>

                <label for="userEmail" class="form-label">Customer Email:</label>
                <input type="email" name="userEmail" class="form-control" value="<?php echo $row['email']; ?>" required><br>

                <label for="userPhone" class="form-label">Customer Phone:</label>
                <input type="tel" name="userPhone" class="form-control" value="<?php echo $row['phone']; ?>" required><br>

                <label for="remarks" class="form-label">Catatan:</label>
                <textarea name="remarks" class="form-control" required><?php echo $row['cat']; ?></textarea><br>

                <label for="payAmount" class="form-label">Subtotal:</label>
                <input type="number" name="payAmount" class="form-control" value="<?php echo $row['subtotal']; ?>" required><br>

                <label for="expireTime" class="form-label">Batas Waktu:</label>
                <input type="datetime-local" name="expireTime" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['time'])); ?>" required><br>

                <label for="items" class="form-label">Items:</label>
                <div id="items-container">
                    <?php
                    // Loop through items data and generate input fields
                    $items = json_decode($row['item'], true);
                    foreach ($items as $item) {
                    ?>
                        <div class="item">
                            <input type="text" name="itemName[]" class="form-control" value="<?php echo $item['name']; ?>" placeholder="Keterangan" required>
                            <input type="hidden" name="itemType[]" value="ITEM" class="form-control" placeholder="Item Type" required>
                            <input type="number" name="itemCount[]" class="form-control" value="<?php echo $item['count']; ?>" placeholder="Cicilan ke-" required>
                            <input type="number" name="itemTotalPrice[]" class="form-control" value="<?php echo $item['total_price']; ?>" placeholder="Total" required>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <button type="button" onclick="addNewItem()" class="btn btn-secondary mb-3">Add Item</button><br>
                <input type="submit" class="btn btn-primary" value="Create Invoice">
            </form>
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
<?php
        } else {
            echo "Data tidak ditemukan.";
        }
    } else {
        echo "Parameter ID tidak valid.";
    }
}
// Tutup koneksi
$conn->close();
?>
