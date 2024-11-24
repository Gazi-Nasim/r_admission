<?php

function from_bkash_date($dateString): \Carbon\Carbon
{
    // '2023-03-12T02:14:52:883 GMT+0600'
    $dateArray = explode(' ', $dateString);
    $date = $dateArray[0];

    $date = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s:u', $date);
    $date->setTimezone('Asia/Dhaka');
    return $date;
}


function bkash_payment_expired($payment): bool
{
    if ($payment?->transactionStatus == 'Completed') {
        return false;
    }

    $date = from_bkash_date($payment->paymentCreateTime);
    return now()->diffInMinutes($date) > 60;

}
