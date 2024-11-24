<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Hsc;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UpdatePhotoSimilarityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:photo_similarity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Photo Similarity';

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
     * @return int
     */
    public function handle()
    {
        $photoDirectory =  storage_path('app/public/uploads/');

        $this->info('photo directory : ' . $photoDirectory);

        $bar = $this->output->createProgressBar(Application::count());

        foreach (Application::lazy() as $application) {

            // applicant
            $applicant = Hsc::find($application->applicant_id);
            if (!$applicant) {
                $error = 'applicant not found: ' . $application->applicant_id;
                $this->error($error);
                Log::channel('photo_matching')->error($error);
                continue;
            }

            // photo
            $photoPath = $photoDirectory . $applicant->photo;
            if (!file_exists($photoPath)) {
                $error = 'photo not found for application : ' . $application->id;
                $this->error($error);
                Log::channel('photo_matching')->error($error);
                continue;
            }

            // Selfie
            $selfiePath = $photoDirectory . $applicant->selfie;
            if (!file_exists($selfiePath)) {
                $error = 'Selfie not found for application : ' . $application->id;
                $this->error($error);
                Log::channel('photo_matching')->error($error);
                continue;
            }

            // get similarity
            $pythonScript = base_path('faced.py');
            $process = new Process(['python3', $pythonScript, $photoPath, $selfiePath]);
            try {
                $process->mustRun();
                $similarity = $process->getOutput();

                // has Error ?
                if (Str::contains($similarity, 'Error')) {
                    $this->error($similarity);
                    Log::channel('photo_matching')->error($similarity);
                    continue;
                }

                // save similarity
                $applicant->photo_similarity = $similarity;
                $applicant->save();
            } catch (ProcessFailedException $exception) {
                $this->error($exception->getMessage());
                return;
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
