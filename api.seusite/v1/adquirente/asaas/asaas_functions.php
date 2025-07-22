<?php

function asaasRequest($endpoint, $method = 'POST', $data = null) {
    $apiKey = '$aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjA4NjUwMjBlLTljZTktNDYwMy1iMGU2LWQxYmYwN2IxYTc4ZTo6JGFhY2hfMjE1YzI1MmYtYzk2ZC00YWYzLTk4NmUtZmVmYjQ4NmY3NDdj'; // substitua
    $url = "https://sandbox.asaas.com/api/v3/$endpoint";

    $headers = [
        "Content-Type: application/json",
        "access_token: $apiKey",
        "User-Agent: MyApp/1.0"
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => false, // para evitar erro SSL
    ]);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }


    $response = curl_exec($ch);


    if (curl_errno($ch)) {
        return ['curl_error' => curl_error($ch)];
    }
    curl_close($ch);
    return json_decode($response, true);
}
