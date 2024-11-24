<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    public function index()
    {
        $path = base_path('storage/logs');
        $files = File::files($path);

        return view('admin.log.index')
            ->with('files', $files);

    }


    public function download($file)
    {
        $path = base_path('/storage/logs/'.$file);

        return response()->download($path);
    }


    public function view($file)
    {
        $path = base_path('/storage/logs/'.$file);

        $content = File::get($path);

        return view('admin.log.view')
            ->with('file', $file)
            ->with('content', $content);
    }

}
