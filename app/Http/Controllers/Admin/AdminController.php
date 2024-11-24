<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Bill;
use App\Models\Enrollment;
use App\Models\InfoReview;
use App\Models\MobileChange;
use App\Models\OthStudent;
use App\Models\PhotoReview;
use App\Models\SubjectOption;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private $cacheTime = 60;

    public function dashboard()
    {
        return $this->finalApplicationDashboard();
        //return $this->preliminaryDashboard();
        //return $this->subjectChoiceDashboard();
    }

    public function dashboardOld()
    {
        $num_oth = OthStudent::status(null)->count();

        $num_review = InfoReview::status(null)->count();

        $num_photo_review = PhotoReview::status(null)->where('bill_status', '1')->count();

        $applications = Cache::remember('applications', $this->cacheTime, function () {
            return Application::select(DB::raw('count(*) as total'), 'unit')
                ->groupBy('unit')
                ->pluck('total', 'unit');
        });

        $paidThrough = Cache::remember('$paidThrough', $this->cacheTime, function () {
            return Bill::select(DB::raw('sum(amount) as total'), 'payment_method')
                ->where('payment_status', '1')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method');
        });


        $daily_applications = Cache::remember('daily_applications', $this->cacheTime, function () {
            return Application::select(DB::raw('count(id) as total, DATE(created_at) as date'))
                ->groupBy('date')
                ->pluck('total', 'date');
        });


        //total bills
        $bills = Cache::remember('bills', $this->cacheTime, function () {
            return Bill::select(DB::raw('count(*) as total'), 'payment_status')
                ->where('payment_purpose', 'A')
                ->groupBy('payment_status')
                ->pluck('total', 'payment_status');
        });


        $applicationByGroup = Cache::remember('applicationByGroup', $this->cacheTime, function () {
            return Application::select(DB::raw('count(*) as total'), 'unit', 'hsc.ru_hsc_group')
                ->join('hsc', 'applications.applicant_id', '=', 'hsc.id')
                ->groupBy('unit', 'ru_hsc_group')
                ->orderby('unit')
                ->get();
        });


        $applicationByGroup = array_chunk($applicationByGroup->toArray(), 3);
//        dd($applicationByGroup);

        $jobs        = DB::table('jobs')->count();
        $failed_jobs = DB::table('failed_jobs')->count();

        $admitCardDownloadCount = Application::where('download_count', '>', 0)->count();


        return view('admin.dashboard')
            ->with('jobs', $jobs)
            ->with('failed_jobs', $failed_jobs)
            ->with('enrollments', $applications)
            ->with('daily_enrollments', $daily_applications)
            ->with('bills', $bills)
            ->with('paidThrough', $paidThrough)
            ->with('applicationByGroup', $applicationByGroup)
            ->with('num_review', $num_review)
            ->with('num_photo_review', $num_photo_review)
            ->with('num_oth', $num_oth)
            ->with('admitCardDownloadCount', $admitCardDownloadCount);
    }



    public function preliminaryDashboard()
    {
        $num_oth = OthStudent::status(null)->count();

        $num_review = InfoReview::status(null)->count();

        $num_photo_review = PhotoReview::status(null)->where('bill_status', '1')->count();

        $num_mobile_changes = MobileChange::status(null)->count();

        $applications = Cache::remember('enrollments', $this->cacheTime, function () {
            return Enrollment::select(DB::raw('count(*) as total'), 'unit')
                ->groupBy('unit')
                ->pluck('total', 'unit');
        });

        $paidThrough = Cache::remember('$paidThrough', $this->cacheTime, function () {
            return Bill::select(DB::raw('sum(amount) as total'), 'payment_method')
                ->where('payment_status', '1')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method');
        });


        $daily_applications = Cache::remember('daily_applications', $this->cacheTime, function () {
            return Enrollment::select(DB::raw('count(id) as total, DATE(created_at) as date'))
                ->groupBy('date')
                ->pluck('total', 'date');
        });


        //total bills
        $bills = Cache::remember('bills', $this->cacheTime, function () {
            return Bill::select(DB::raw('count(*) as total'), 'payment_status')
                ->where('payment_purpose', 'E')
                ->groupBy('payment_status')
                ->pluck('total', 'payment_status');
        });


        $applicationByGroup = Cache::remember('applicationByGroup', $this->cacheTime, function () {
            return Enrollment::select(DB::raw('count(*) as total'), 'unit', 'hsc.ru_hsc_group')
                ->join('hsc', 'enrollments.applicant_id', '=', 'hsc.id')
                ->groupBy('unit', 'ru_hsc_group')
                ->orderby('unit')
                ->get();
        });


        $applicationByGroup = array_chunk($applicationByGroup->toArray(), 3);
//        dd($applicationByGroup);

        $jobs        = DB::table('jobs')->count();
        $failed_jobs = DB::table('failed_jobs')->count();

        $admitCardDownloadCount = Application::where('download_count', '>', 0)->count();


        return view('admin.preliminary_dashboard')
            ->with('jobs', $jobs)
            ->with('failed_jobs', $failed_jobs)
            ->with('enrollments', $applications)
            ->with('daily_enrollments', $daily_applications)
            ->with('bills', $bills)
            ->with('paidThrough', $paidThrough)
            ->with('applicationByGroup', $applicationByGroup)
            ->with('num_review', $num_review)
            ->with('num_photo_review', $num_photo_review)
            ->with('num_oth', $num_oth)
            ->with('num_mobile_changes', $num_mobile_changes)
            ->with('admitCardDownloadCount', $admitCardDownloadCount);
    }


    public function finalApplicationDashboard()
    {
        $num_oth = OthStudent::status(null)->count();

        $num_review = InfoReview::status(null)->count();

        $num_photo_review = PhotoReview::status(null)->where('bill_status', '1')->count();

        $num_mobile_changes = MobileChange::status(null)->count();

        $applications = Cache::remember('applications', $this->cacheTime, function () {
            return Application::select(DB::raw('count(*) as total'), 'unit')
                ->groupBy('unit')
                ->pluck('total', 'unit');
        });

        $paidThrough = Cache::remember('$paidThrough', $this->cacheTime, function () {
            return Bill::select(DB::raw('sum(amount) as total'), 'payment_method')
                ->where('payment_status', '1')
                ->groupBy('payment_method')
                ->pluck('total', 'payment_method');
        });


        $daily_applications = Cache::remember('daily_applications', $this->cacheTime, function () {
            return Application::select(DB::raw('count(id) as total, DATE(created_at) as date'))
                ->groupBy('date')
                ->pluck('total', 'date');
        });


        //total bills
        $bills = Cache::remember('bills', $this->cacheTime, function () {
            return Bill::select(DB::raw('count(*) as total'), 'payment_status')
                ->whereIn('payment_purpose', ['A','PR'])
                ->groupBy('payment_status')
                ->pluck('total', 'payment_status');
        });


        $applicationByGroup = Cache::remember('applicationByGroup', $this->cacheTime, function () {
            return Application::select(DB::raw('count(*) as total'), 'unit', 'hsc.ru_hsc_group')
                ->join('hsc', 'applications.applicant_id', '=', 'hsc.id')
                ->groupBy('unit', 'ru_hsc_group')
                ->orderby('unit')
                ->get();
        });


        $applicationByGroup = array_chunk($applicationByGroup->toArray(), 3);
//        dd($applicationByGroup);

        $jobs        = DB::table('jobs')->count();
        $failed_jobs = DB::table('failed_jobs')->count();

        $admitCardDownloadCount = Application::where('download_count', '>', 0)->count();


        return view('admin.preliminary_dashboard')
            ->with('jobs', $jobs)
            ->with('failed_jobs', $failed_jobs)
            ->with('enrollments', $applications)
            ->with('daily_enrollments', $daily_applications)
            ->with('bills', $bills)
            ->with('paidThrough', $paidThrough)
            ->with('applicationByGroup', $applicationByGroup)
            ->with('num_review', $num_review)
            ->with('num_photo_review', $num_photo_review)
            ->with('num_oth', $num_oth)
            ->with('num_mobile_changes', $num_mobile_changes)
            ->with('admitCardDownloadCount', $admitCardDownloadCount);
    }




    public function subjectChoiceDashboard()
    {
        $num_oth = OthStudent::status(null)->count();

        $num_review = InfoReview::status(null)->count();

        $num_photo_review = PhotoReview::status(null)->where('bill_status', '1')->count();

        $subjectChoices = Cache::remember('subjectChoices', $this->cacheTime, function () {
            return SubjectOption::select(DB::raw('count(*) as total'), 'unit')
                ->where('sub_completed',1)
                ->orderBy('unit')
                ->groupBy('unit')
                ->pluck('total', 'unit');
        });


        return view('admin.subject_choice_dashboard')
            ->with('subjectChoices', $subjectChoices)
            ->with('num_review', $num_review)
            ->with('num_photo_review', $num_photo_review)
            ->with('num_oth', $num_oth);
    }




}
