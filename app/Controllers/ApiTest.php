<?php

namespace App\Controllers;

use Config\Api;

class ApiTest extends BaseController
{
    public function index()
    {
        $api = new Api();
        $client = \Config\Services::curlrequest();

        // Call API safely
        try {
            $response = $client->get($api->baseURL . 'users', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $api->apiKey
    ]
]);
            $users = json_decode($response->getBody());
        } catch (\Exception $e) {
            $users = [];
        }

        // IMPORTANT:
        // Use BaseController data ONLY (do NOT re-call models here)
        return view('pages/commons/api_test', array_merge($this->data, [
        'users' => $users
    ]));
    }
}