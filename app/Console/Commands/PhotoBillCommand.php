<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Hsc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PhotoBillCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create bills for rejected photo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {

        $this->info('Photo Bill Command Started');

        $hscId = Hsc::query()
            ->join('applications', 'applications.applicant_id', '=', 'hsc.id')
            ->where(function ($query) {
                $query->orWhere('hsc.photo_status', '=', 'R')
                    ->orWhere('hsc.selfie_status', '=', 'R');
            })->distinct('hsc.id')->pluck('hsc.id');


        $billAmount = 220;

        $bar = $this->output->createProgressBar(count($hscId));

        foreach ($hscId as $studentId) {
            $bill = new Bill();
            $bill->applicant_id = $studentId;
            $bill->bill_number ='123';
            $bill->amount = $billAmount;
            $bill->payment_purpose = 'PR';
            $bill->payment_status = 0;
            $bill->save();
            $bar->advance();

        }

        $bar->finish();
    }

}
