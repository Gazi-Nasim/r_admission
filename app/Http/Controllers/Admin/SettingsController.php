<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = setting()->all();

        $text_boxes = [
           'sms_credit','show_results_for'
        ];

        return view('admin.settings.index')
            ->with('page_title', 'Settings')
            ->with('text_boxes', $text_boxes)
            ->with('settings', $settings);
    }

    public function save(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            setting()->set($key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('settings-saved', 1);
    }
}
