<?php
function apiRequest($method, $url, $data = null, $token = null) {
    $curl = curl_init($url);
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($curl);
    if (curl_errno($curl)) {
    echo '<p style="color:red;">Lỗi cURL: ' . curl_error($curl) . '</p>';
    }
    curl_close($curl);

    return $result;
}
