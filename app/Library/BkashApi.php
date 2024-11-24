<?php

namespace App\Library;


use Cache;
use Exception;
use GuzzleHttp\Client;
use RuntimeException;

class BkashApi
{

    private array $requestConfig;
    private $config;
    private $access_token;

    public function __construct()
    {
        $this->config = config('bkash');

        try {
            $this->access_token = Cache::remember('bkash_access_token', 3000, function () {
                return $this->getAccessToken();
            });
        } catch (Exception $e) {
            throw new TokenNotCreatedException('Token Creation Failed!');
        }


    }


    public function getAccessToken()
    {
        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type' => 'application/json',
                'username'     => $this->config['user_name'],
                'password'     => $this->config['password'],
            ],
        ];


        $client = new Client($this->requestConfig);

        $requestBody = [
            "app_key"    => $this->config['app_key'],
            "app_secret" => $this->config['app_secret'],
        ];

        try {

            $response = $client->post('tokenized/checkout/token/grant', [
                'body' => json_encode($requestBody),
            ]);

            // request failed
            if ($response->getStatusCode() != 200) {
                return null;
            }

            $data = json_decode($response->getBody()->getContents(), false);

            // api error response
            if ($data->statusCode !== '0000') {
                return null;
            }
            return $data->id_token;

        } catch (Exception $e) {
            throw new RuntimeException('Token Creation Failed!');
        }


    }

    public function createPayment($transaction)
    {

        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'authorization' => $this->access_token,
                'x-app-key'     => $this->config['app_key'],
            ],
        ];


        $client = new Client($this->requestConfig);

        $requestBody = [
            "mode"                  => "0011",
            "payerReference"        => $transaction['payerRef'],
            "callbackURL"           => route($this->config['return_url']),
            "amount"                => $transaction['amount'],
            "currency"              => "BDT",
            "intent"                => "sale",
            "merchantInvoiceNumber" => $transaction['billId'],

        ];


        $response = $client->post('tokenized/checkout/create', [
            'body' => json_encode($requestBody),
        ]);


        if ($response->getStatusCode() != 200) {
            throw new RuntimeException('Invalid response code');
        }

        $data = json_decode($response->getBody()->getContents(), false);


        if ($data->statusCode === '0000') {
            return $data;
        } else {
            throw new RuntimeException($data->statusMessage);
        }


    }


    public function executePayment($paymentID)
    {

        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'authorization' => $this->access_token,
                'x-app-key'     => $this->config['app_key'],
            ],
        ];


        $client = new Client($this->requestConfig);

        $requestBody = [
            'paymentID' => $paymentID,
        ];


        try {

            $response = $client->post('tokenized/checkout/execute', [
                'body' => json_encode($requestBody),
            ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception('Invalid response code');
            }

            $data = json_decode($response->getBody()->getContents(), false);


            if ($data->statusCode === '0000') {
                return $data;
            } else {
                throw new RuntimeException($data->statusMessage);
            }

        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());

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
                'authorization' => $this->access_token,
                'x-app-key'     => $this->config['app_key'],
            ],
        ];

        $client = new Client($this->requestConfig);

        $requestBody = [
            'paymentID' => $paymentID,
        ];


        try {

            $response = $client->post('tokenized/checkout/payment/status', [
                'body' => json_encode($requestBody),
            ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception('Invalid response code');
            }

            $data = json_decode($response->getBody()->getContents(), false);

            if ($data->statusCode == '0000') {
                return $data;
            } else {
                return null;
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }


    public function searchTransaction($trxID)
    {
        $this->requestConfig = [
            'base_uri' => $this->config['api_url'],
            'timeout'  => 30.0,
            'verify'   => false,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'authorization' => $this->access_token,
                'x-app-key'     => $this->config['app_key'],
            ],
        ];

        $client = new Client($this->requestConfig);

        $requestBody = [
            'trxID' => $trxID,
        ];


        try {

            $response = $client->post('tokenized/checkout/general/searchTransaction', [
                'body' => json_encode($requestBody),
            ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception('Invalid response code');
            }

            $data = json_decode($response->getBody()->getContents(), false);

            if ($data->statusCode == '0000') {
                return $data;
            } else {
                throw new Exception($data->statusMessage);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());

        }
    }


}
