<?php
namespace App\Library;

use GuzzleHttp\Client;

/**
 * CLass for bkash payment
 */
class RUSms
{

    function __construct()
    {
        # code...
    }

    public static function sendSms($mobile_no, $msg, $sender='RU')
    {

        if (config('app.debug')) {
            $mobile_no = '01928788589';
        }

        $msg = "(RU)\n$msg";
        $data = RobiSms::sendSms($mobile_no, $msg);

        //$data[MessageId] => 1678799043272748;
        //$data[Status] => 0;
        //$data[StatusText] => success;
        //$data[ErrorCode] => 0;
        //$data[ErrorText] =>;
        //$data[SMSCount] => 1;
        //$data[CurrentCredit] => 75024.40;
        if ( $data['StatusText'] == 'success' ) {
            setting(['sms_credit' => $data['CurrentCredit']]);
        }


        return $data;

        $client = new Client();

        $url = "http://103.79.117.108/sms/push/send.php";

        $request_data = [
            "sender"   => $sender,
            "password" => 'rU@dm1s5ion5MS6etway',
            "mobile"   => $mobile_no,
            "msg"      => $msg
        ];

        $response = $client->post($url, ['form_params' => $request_data]);

        return $response->getStatusCode() == 200;


    }


}


?>
