<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Hsc;
use App\Notifications\EmailAdmitCardNotification;
use App\Notifications\EmailPinNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class MailAdmitCardCommand extends Command
{
    protected $signature = 'mail:admit-card';

    protected $description = 'Command description';

    public function handle()
    {
        $applicants = Application::query()
            ->distinct()
            ->where('download_count', 0)
            ->select('applicant_id')
            ->get();

        $applicants->chunk(10)->each(function ($applicant_ids) {

            $students = Hsc::whereIn('id', $applicant_ids)
                ->whereNotNull('email')
                ->get();
            Notification::send($students, (new EmailAdmitCardNotification()));
        });

        Notification::route('mail', 'm.r.kushal@gmail.com')
            ->notify((new EmailPinNotification('Kushal', 'm.r.kushal@gmail.com', 'Done')));

        $this->info('Done');

    }
}
