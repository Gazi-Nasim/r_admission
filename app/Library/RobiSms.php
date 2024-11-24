<?php
namespace App\Library;

use GuzzleHttp\Client as GuzzleHttpClient;
use SimpleXMLElement;

/**
 * CLass for bkash payment
 */
class RobiSms
{

    public static function sendSms($mobile_no, $msg)
    {

        //https://api.mobireach.com.bd/SendTextMessage?Username=jaguni&Password=Gst@20212022&From=8801810107222&To=8801911064969&Message=Your request has been received succefffully
        $client = new GuzzleHttpClient(['base_uri' => 'https://api.mobireach.com.bd', 'timeout' => 10.0]);

        $response = $client->request('GET', 'SendTextMessage', [
            'query' => [
                'Username' => 'uniraj',
                'Password' => 'RuICT@4969',
                'From'     => '8801844520366',
                'To'       => '88'.$mobile_no,
                'Message'  => $msg,
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            $xml_response = $response->getBody()->getContents();

            $xml = new SimpleXMLElement($xml_response);

            $data = $xml->ServiceClass;

            $return_data = [];

            foreach ($data->children() as $node) {
                $return_data[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
            }

            return $return_data;

        } else {
            return null;
        }


    }


}


?>
