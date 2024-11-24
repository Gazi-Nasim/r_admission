<?php

namespace App\Library;

use GuzzleHttp\Client;

class FormSubmitter
{
    public static function submit($url, $data)
    {
        $client = new Client();
        $response = $client->post($url, ['form_params' => $data]);

        return $response->getStatusCode() == 200;
    }


}
