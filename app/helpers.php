<?php

function hello()
{
    return 'hello';
}

function upload_to_imgur($file_path)
{
    $result = [];

    $url = config('services.imgur.endpoint');

    $img = base64_encode(file_get_contents($file_path));

    $parameter = [
        'headers' => [
            'Authorization' => 'Client-ID '.config('services.imgur.client_id'),
            'x-rapidapi-key' => config('services.imgur.key'),
        ],
        'form_params' => ['image' => $img],
        'timeout' => 30,
        'verify' => false,
    ];

    $client = new \GuzzleHttp\Client();

    $response = json_decode($client->post($url, $parameter)->getBody(), true);

    return $response;
}
