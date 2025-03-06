<?php
$host = 'http://51.79.242.222';
$port = '8013';
$username = 'DEV';
$password = 'DEV';

// Get Token
$pathToken = '/api/oauth/token';
$urlGetToken = $host . ':' . $port . $pathToken;

$chGetToken = curl_init($urlGetToken);
// curl_setopt($chGetToken, CURLOPT_USERPWD, $username . ":" . $password);
// curl_setopt($chGetToken, CURLOPT_POST, 1);
curl_setopt($chGetToken, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($chGetToken, CURLOPT_ENCODING, '');
curl_setopt($chGetToken, CURLOPT_MAXREDIRS, 10);
curl_setopt($chGetToken, CURLOPT_TIMEOUT, 0);
curl_setopt($chGetToken, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($chGetToken, CURLOPT_HTTP_VERSION,
CURL_HTTP_VERSION_1_1);
curl_setopt($chGetToken, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($chGetToken, CURLOPT_HTTPHEADER, array(
'Authorization: Basic '.base64_encode($username.':'.$password)
));

$result = curl_exec($chGetToken);
$nilai=json_decode($result);
$accessToken=$nilai->responseData->accessToken;
//echo $accessToken;
curl_close($chGetToken);
?>