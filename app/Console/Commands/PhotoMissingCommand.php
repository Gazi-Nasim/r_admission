<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\MiscController;
use App\Models\Bill;
use App\Models\Hsc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PhotoMissingCommand extends Command
{
    protected $signature = 'photo:missing';

    protected $description = 'Checks for missing photos';

    public function handle()
    {
        $start = now();
        $applicant_ids = collect();

        Bill::where('payment_status',1)
            ->where('payment_purpose','A')
            ->select('applicant_id')
            ->distinct()
            ->chunk(1000, function ($ids) use ($applicant_ids) {

                $students = Hsc::whereIn('id', $ids)
                    ->get(['NAME','photo','id']);

                foreach($students as $student){
                    $photo_path ='public/uploads/'.$student->photo;
                    if (!Storage::exists($photo_path)) {
                        $applicant_ids->push([$student->id,$student->photo]);
                    }
                }

            });

        $this->info('Done');

        echo "========missing photo==========\n";
        foreach($applicant_ids as $id){
            echo $id[0].'=>'.$id[1]."\n";
        }

        echo $time = now()->diffForHumans($start);

    }
}
