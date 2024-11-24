<?php

namespace App\Console\Commands;

use App\Library\BkashApi;
use App\Models\Bill;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BkashPaymentCheckCommand extends Command
{
    protected $signature = 'bkash:payment-check';

    protected $description = 'Command description';

    public function handle(): void
    {
        $payments =Bill::where('payment_status','0')
            ->whereNotNull('bkash_payment_id')
            ->get();

        $this->info('Total pending payments: '.$payments->count());

        $bkashApi = new BkashApi();

        $missingPayments = [];
        try {
            foreach ($payments as $payment) {
                $this->info('Checking payment: '.$payment->id);

                $result   = $bkashApi->queryPayment($payment->bkash_payment_id);

                if ( $result && property_exists($result, 'trxID') ) {
                    $missingPayments[$payment->id] = $result->trxID;
                    $this->error('Missing payment: '.$payment->id);
                }
            }
            $this->info('Total missing payments: '.count($missingPayments));
            //save missing payments as json in storage/app/missing_payments.json

            Storage::put('missing_payments.json', json_encode($missingPayments, JSON_PRETTY_PRINT));

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }



    }
}
