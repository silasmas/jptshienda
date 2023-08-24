<?php
/**
 * Copyright (c) 2023 Xsam Technologies and/or its affiliates. All rights reserved.
 */

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ApiClientManager
{
    /**
     * Manage API calling
     *
     * @param  $method
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function call($method, $url, $data_to_send = [])
    {
        // Client used for accessing API
        $client = new Client();

        try {
            $response = $client->request($method, $url, [
                'headers' => [
                    'Authorization' => 'Bearer -----------',
                    'Accept' => 'application/json',
                    'X-localization' => !empty(Session::get('locale')) ? Session::get('locale') : App::getLocale(),
                ],
                'form_params' => $data_to_send,
                'verify' => false,
            ]);
            $result = json_decode($response->getBody(), false);

            return $result;

        } catch (ClientException $e) {
            $result = json_decode($e->getResponse()->getBody()->getContents(), false);

            return $result;
        }
    }
}
