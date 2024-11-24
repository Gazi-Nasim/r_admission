<?php

namespace App\Library;


use Cache;
use Exception;
use GuzzleHttp\Client;
use RuntimeException;

class RocketApi
{

    private array $requestConfig;
    private $config;
    private $api_token;

    public function __construct()
    {
        $this->config = config('rocket');

        $this->api_token = $this->config['api_token'];

    }


    public function createPayment($transaction)
    {

        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'authorization' => 'Bearer '. $this->api_token,
                'Accept' => 'application/json',
            ],
        ];


        $client = new Client($this->requestConfig);

        $requestBody = [
            'bill_id' => $transaction['billId'],
            'amount' => $transaction['amount'],
            "mobile" => $transaction['mobile_no'],
            "name" => $transaction['name'],
            'callback_url' => route('rocket.return'),
        ];


        $response = $client->post('api/create_payment', [
            'body' => json_encode($requestBody),
        ]);


        if ($response->getStatusCode() != 200) {
            throw new RuntimeException('Invalid response code');
        }

        $data = json_decode($response->getBody()->getContents(), false);


        //dd($data);

        if ($data->status_code === 0) {
            return $data;
        } else {
            throw new RuntimeException($data->status_message);
        }
    }


    public function queryPayment($paymentID)
    {
        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'authorization' => 'Bearer '. $this->api_token,
                'Accept' => 'application/json',
            ],
        ];

        $client = new Client($this->requestConfig);

        $requestUrl = 'api/payment_status/' . $paymentID;


        try {

            $response = $client->post($requestUrl);
            if ($response->getStatusCode() != 200) {
                throw new Exception('Invalid response code');
            }

            $data = json_decode($response->getBody()->getContents(), false);

            return $data;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
