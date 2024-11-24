<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Unit;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function index()
    {
        $unit = Unit::pluck('unit_name', 'unit_name')->toArray();

        return view('admin.admit_card.index')
            ->with('unit', $unit);
    }

    public function search(Request $request)
    {
//        if (!$request->filled('unit')) {
//            return '<div class="alert alert-danger">
//						<strong>Please Select Unit</strong>
//					 </div>';
//        }

        if (!$request->filled('admission_roll') && !auth()->user()->hasRole(['Admin','Operator'])) {
            return '<div class="alert alert-danger">
						<strong>Please Select Admission Roll</strong>
					 </div>';
        }

        $db = Application::query();

        if ($request->filled('admission_roll')) {
            $db = $db->where('admission_roll', $request->admission_roll);
        }

        if ($request->filled('applicant_id')) {
            $db = $db->where('applicant_id', $request->applicant_id);
        }

        if ($request->filled('name')) {
            $db = $db->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('fname')) {
            $db = $db->where('fname', 'like', '%'.$request->fname.'%');
        }

        if ($request->filled('mname')) {
            $db = $db->where('mname', 'like', '%'.$request->mname.'%');
        }


//        $applications = $db->where('unit', $request->unit)
//            ->limit(50)
//            ->get();

        $applications = $db->limit(50)->get();

        if ($applications->count() <= 1) {
            return view('admin.admit_card.search_result')
                ->with('application', $applications?->first());
        } else {
            return view('admin.admit_card.search_result_many')
                ->with('applications', $applications);
        }


        return view('admin.admit_card.search_result')
            ->with('application', $application);


    }
}
