<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\DropDownHelper;
use App\Library\RUSms;
use App\Models\Application;
use App\Models\Hsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PhotoCheckController extends Controller
{
    public function index()
    {
        ini_set('max_execution_time', 12000);
        // ini_set('memory_limit', 2048);


        $hsc_board = DropDownHelper::getHscBoards();

//        $total_photos = [];
//        foreach ($hsc_board as $key => $value) {
//            $applicant_count = Application::distinct('applicant_id')
//                ->select('applicant_id')
//                ->where('hsc_board', $key)
//                ->count();
//
//            $total_photos[strtoupper($key)] = $applicant_count;
//        }

        $total_photos = Application::query()
            ->select('hsc_board', DB::raw('COUNT(DISTINCT applicant_id) AS count'))
            ->groupBy('hsc_board')
            ->get()
            ->pluck('count', 'hsc_board')->toArray();

        // $ids = Application::distinct('applicant_id')
        // 						->lists('applicant_id');


        // $total_photos = Hsc::select('HSC_BOARD_NAME',DB::raw('count(*) AS PHOTO_COUNT') )
        // 					->whereIn('id',$ids)
        // 					->groupBy('HSC_BOARD_NAME')
        // 					->orderby('HSC_BOARD_NAME')
        // 					->lists('PHOTO_COUNT','HSC_BOARD_NAME');

        $checked_photo = Cache::remember('checked_photo', 6, function () {
            return Hsc::select('HSC_BOARD_NAME', DB::raw('count(*) AS PHOTO_COUNT'))
                ->whereNotNull('photo_status')
                ->whereNotNull('selfie_status')
                ->groupBy('HSC_BOARD_NAME')
                ->orderby('HSC_BOARD_NAME')
                ->get()
                ->pluck('PHOTO_COUNT', 'HSC_BOARD_NAME')->toArray();
        });



        return view('admin.photo_check.index')
            ->with('hsc_board', $hsc_board)
            ->with('checked_photo', $checked_photo)
            ->with('total_photos', $total_photos);
    }

    public function getPhotos(Request $request, $board)
    {
        $hsc_board       = str_replace('-', '/', $board);
        $exclude_missing = $request->input('exclude_missing', 0);

        //get photos that are in master_table but not in photo_checks
        $db = Hsc::join('applications', 'hsc.id', '=', 'applications.applicant_id')
            ->where(function ($query) {
                $query->whereNull('photo_status')
                    ->orWhereNull('selfie_status');
            })
            ->where('HSC_BOARD_NAME', $hsc_board)
            ->distinct('applicant_id');


        if ($exclude_missing) {
            $db = $db->whereIn('has_photo', [1, 2]);
        }

        $data = $db->select(['hsc.photo', 'hsc.id','hsc.selfie','hsc.photo_status', 'hsc.selfie_status'])
            ->paginate(100)->withQueryString();

        return view('admin.photo_check.search_result')
            ->with('data', $data);

    }


    public function setStatus(Request $request, $hsc_id, $status)
    {

        if (!empty($hsc_id) && !empty($status)) {

            $student = Hsc::findOrFail($hsc_id);
            $msg = null;
            $return = null;

            switch ($status) {
                case 'AP':
                    $student->photo_status     = 'A';
                    break;
                case 'RP':
                    $student->photo_status     = 'R';
                    $msg = sprintf("%s, your application photo is rejected. Upload photo with clear face and ears according to photo instruction.\n-RU", $student->NAME);
                    RUSms::sendSms($student->mobile_no, $msg, 'RU');
                    break;
                case 'AS':
                    $student->selfie_status     = 'A';
                    break;
                case 'RS':
                    $student->selfie_status     = 'R';
                    $msg = sprintf("%s, your selfie is rejected. capture selfie with clear face and ears according to selfie instruction.\n-RU", $student->NAME);
                    RUSms::sendSms($student->mobile_no, $msg, 'RU');
                    break;
            }

            $student->photo_checked_by = auth()->user()->id;
            $student->save();

            return sprintf('<a class="btn btn-xs btn-default" href="#" disabled="">%s</a>', $status);


        } else {
            return '<p class="btn btn-warning">status : Status Empty</p>';
        }

    }

    public function indexRejectedPhoto()
    {

        $data = Hsc::where('photo_status', 'R')
            ->where('selfie_status', 'A')
            ->paginate(100);

        return view('admin.photo_check.index_reject')
            ->with('data', $data);
    }


    public function indexRejectedSelfie()
    {

        $data = Hsc::where('photo_status', 'A')
            ->where('selfie_status', 'R')
            ->paginate(100);

        return view('admin.photo_check.index_reject')
            ->with('data', $data);
    }


}
