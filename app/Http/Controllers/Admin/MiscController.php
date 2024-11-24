<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Bill;
use App\Models\Hsc;
use App\Services\IdentityVerificationService;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MiscController extends Controller
{
    public function photoMissing()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $applicant_ids = collect();

        Bill::where('payment_status', 1)
            ->where('payment_purpose', 'A')
            ->limit(1000)
            ->chunk(100, function ($bills) use ($applicant_ids) {

                $students = Hsc::whereIn('id', $bills->pluck('applicant_id')->unique())
                    ->get(['NAME', 'photo', 'id']);

                foreach ($students as $student) {
                    $photo_path = 'public/uploads/'.$student->photo;
                    if (!Storage::exists($photo_path)) {
                        $applicant_ids->push([$student->id, $student->photo]);
                    }
                }

            });

        echo '========missing photo==========<br>';
        foreach ($applicant_ids as $id) {
            echo $id[0].'===>'.$id[1].'<br>';
        }

    }


    public function quotaPhotoMissing()
    {
        $applicant_chunks = Bill::where('payment_status', 1)
            ->pluck('applicant_id')->chunk(100);

        $applicant_ids = collect();
        foreach ($applicant_chunks as $applicants) {
            $students = Hsc::whereIn('id', $applicants)->get();

            foreach ($students as $student) {

                $quotas = $student->quota_array;

                foreach ($quotas as $quota) {
                    $photo_path = 'public/uploads/'.$student->{$quota.'_photo'};
                    if (!Storage::exists($photo_path)) {
                        $applicant_ids->push([$student->id, $student->{$quota.'_photo'}]);
                    }
                }

            }
        }

        echo "========missing photo==========\n";
        foreach ($applicant_ids as $id) {
            echo $id[0]."=>".$id[1]."\n";
        }


    }

    public function clearData($type)
    {
        switch ($type) {
            case 'cache':
                //clear cache
                Artisan::call('cache:clear');
                echo 'cache cleared';
                break;
            case 'route':
                //clear route
                Artisan::call('route:clear');
                echo 'route cleared';
                break;
            case 'view':
                //clear view
                Artisan::call('view:clear');
                echo 'view cleared';
                break;
            case 'config':
                //clear config
                Artisan::call('config:clear');
                echo 'config cleared';
                break;
            default:
                echo 'invalid type';
        }
    }

    public function capturedPhotos(Request $request)
    {
        $unit = $request->get('unit');

        $applicant_ids = Bill::where('payment_status', 1)
            ->where('payment_purpose', 'PR')
            ->pluck('applicant_id');

        $suspect_ids = Hsc::whereNotNull('suspect_photo')
            ->pluck('id');

        $applicant_ids = $applicant_ids->merge($suspect_ids);


        $applications = Application::with('student')
            ->whereIn('applicant_id', $applicant_ids)
            ->orderBy('unit')
            ->orderBy('admission_roll')
            ->when($unit, function ($query, $unit) {
                return $query->where('unit',$unit);
            })
            ->get();


        return view('misc.captured_photos', compact('applications'));



    }



}



