<?php

function curlRequest($url, $method, $data = null)
{
    $curl = curl_init();
    $env  = getenv('ASAAS_TOKEN');

    $payload = $data ? json_encode($data) : "";

    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "access_token: $env",
            "User-Agent: WsIntegracoes/1.0",
            "Content-Length: " . strlen($payload)
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #: " . $err;
    }

    return $response;
}

