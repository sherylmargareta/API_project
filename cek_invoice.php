<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .hidden {
      display: none;
      }
    </style>

    <title>Invoice Status</title>
</head>
<body class="container mt-5">

<?php
$host = 'http://51.79.242.222';
$port = '8013';
$pathInvoice = '/api/v1/invoice';
$invoiceId = $_GET['invoiceId'];
$accessToken = $_GET['accessToken'];

$URLCekStatus = $host . ':' . $port . $pathInvoice . "/" . $invoiceId . "?accessToken=" . $accessToken;
$chCekInvoice = curl_init($URLCekStatus);
curl_setopt($chCekInvoice, CURLOPT_TIMEOUT, 30);
curl_setopt($chCekInvoice, CURLOPT_RETURNTRANSFER, TRUE);
$responseCekInvoice = curl_exec($chCekInvoice);
$cekInvoice = json_decode($responseCekInvoice);
$status = $cekInvoice->responseData->invoiceStatus;
?>

<div class="card">
    <div class="card-header" style="background-color: purple;">
        <h5 class="card-title" style="color: white;">Invoice Status</h5>
    </div>
    <div class="card-body">
        <p class="hidden">
            <strong>URL:</strong> 
            <pre class="hidden"> <?php echo $URLCekStatus; ?></pre>
        </p>
        <p class="card-text" style="color: purple; font-weight: bold;">
            <strong>Status:</strong> <?php echo $status; ?>
            <?php if ($status != "PAID") echo "belum dibayar"; ?>
        </p>
        <p class="hidden">
            <strong>Data:</strong>
        </p>
            <pre class="hidden"><?php print_r($cekInvoice); ?></pre>
    </div>
</div>

<!-- Tambahkan tombol kembali ke halaman "HOME" -->
<a href="home.html" class="btn btn-primary mt-3">Kembali ke Halaman Home</a>

</body>
</html>