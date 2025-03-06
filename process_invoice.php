<?php include "token.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container my-4">

        <?php
        $api_key = 'test_apikey';
        $api_secret = 'test_apisecret';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Process the form data
            $invoiceName = $_POST["invoiceName"];
            $referenceId = $_POST["referenceId"];
            $userName = $_POST["userName"];
            $userEmail = $_POST["userEmail"];
            $userPhone = $_POST["userPhone"];
            $remarks = $_POST["remarks"];
            $payAmount = $_POST["payAmount"];
            $expireTime = $_POST["expireTime"];
            
            $bodyCreateInvoice = array(
                "invoiceName" => $invoiceName,
                "referenceId" => $referenceId,
                "userName" => $userName,
                "userEmail" => $userEmail,
                "userPhone" => $userPhone,
                "remarks" => $remarks,
                "payAmount" => $payAmount,
                "expireTime" => $expireTime,
                "items" => array(),
            );
            
            for ($i = 0; $i < count($_POST['itemName']); $i++) {
                $bodyCreateInvoice['items'][] = array(
                    "itemName" => $_POST['itemName'][$i],
                    "itemType" => $_POST['itemType'][$i],
                    "itemCount" => $_POST['itemCount'][$i],
                    "itemTotalPrice" => $_POST['itemTotalPrice'][$i],
                );
            }

            $pathInvoice = '/api/v1/invoice';
            $urlCreateInvoice = $host . ':' . $port . $pathInvoice;
            $signRelativeURLCreateInvoice = parse_url($urlCreateInvoice, PHP_URL_PATH);
            $rawBodyCreateInvoice = json_encode($bodyCreateInvoice);
            $dataToSignCreateInvoice = $api_key . $signRelativeURLCreateInvoice . $rawBodyCreateInvoice;
            $signatureCreateInvoice = hash_hmac('sha256', $dataToSignCreateInvoice, $api_secret);

            $chCreateInvoice = curl_init($urlCreateInvoice);

            $headersCreateInvoice = array(
                "Content-Type: application/json",
                "Authorization: Bearer ". $accessToken,
                "x-aiyo-key: " . $api_key,
                "x-aiyo-signature: " . $signatureCreateInvoice
            );

            curl_setopt($chCreateInvoice, CURLOPT_TIMEOUT, 30);
            curl_setopt($chCreateInvoice, CURLOPT_POST, 1);
            curl_setopt($chCreateInvoice, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($chCreateInvoice, CURLOPT_HTTPHEADER, $headersCreateInvoice);
            curl_setopt($chCreateInvoice, CURLOPT_POSTFIELDS, $rawBodyCreateInvoice);
            $sentHeaders = curl_getinfo($chCreateInvoice, CURLINFO_HEADER_OUT);

            $responseCreateInvoice = curl_exec($chCreateInvoice);
            
            $invoice=json_decode($responseCreateInvoice);

            if ($invoice->responseCode == '2000000') {
            $invoiceId = $invoice->responseData->invoiceId;
            $accessToken = $invoice->responseData->accessToken;

            // Display specific information using Bootstrap classes
            echo "<div class='mt-4 p-4 bg-white border rounded shadow'>";
            echo "<h4 class='mb-4 font-weight-bold'>Invoice Details</h4>";
            echo "<dl class='row'>";
            echo "<dt class='col-sm-3'>ID</dt><dd class='col-sm-9'>" . $invoiceId . "</dd>";
            echo "<dt class='col-sm-3'>URL</dt><dd class='col-sm-9'>" . $invoice->responseData->invoiceURL . "</dd>";
            echo "<dt class='col-sm-3'>Subject</dt><dd class='col-sm-9'>" . $invoice->responseData->invoiceName . "</dd>";
            echo "<dt class='col-sm-3'>Amount</dt><dd class='col-sm-9'>" . $invoice->responseData->payAmount . "</dd>";
            echo "</dl>";
            echo "<p><a href=\"cek_invoice.php?invoiceId=" . $invoiceId . "&accessToken=" . $accessToken . "\" target=\"_blank\" class='btn btn-primary'>Check Invoice Status</a></p>";
            echo "</div>";
        } else {
            // Display error message if responseCode is not 2000000
            echo "<div class='alert alert-danger mt-4'>" . $invoice->responseMessage . "</div>";
        }

        } else {
            // Handle the case where the form is not submitted
            echo "<p class='text-red-500'>Form not submitted.</p>";
        }
        ?>
</div>
    </div>
<!-- Bootstrap JavaScript (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>