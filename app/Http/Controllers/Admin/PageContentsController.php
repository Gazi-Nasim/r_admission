<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentsController extends Controller
{
    public function index()
    {
        $contents = PageContent::all();

        return view('admin.cms.index', compact('contents'));

    }


    public function edit(PageContent $pageContent)
    {
        $pageContent = PageContent::findOrFail($pageContent->id);

        if (empty($pageContent->content_draft)) {
            $pageContent->content_draft = $pageContent->content;
            $pageContent->save();
        }

        return view('admin.cms.edit', compact('pageContent'));

    }

    public function update(Request $request, PageContent $pageContent)
    {
        $pageContent = PageContent::find($pageContent->id);

        $pageContent->content_draft = $request->code;
        $pageContent->draft_published = 0;
        $pageContent->save();

        return redirect()->back()->with('success', 'Draft saved successfully');

    }

    public function publish(Request $request, PageContent $pageContent)
    {
        $pageContent->content = $pageContent->content_draft;
        $pageContent->draft_published = 1;
        $pageContent->save();

        return redirect()->back()->with('success', 'Draft published successfully');

    }
}
