<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['activeMenu'] = 'news';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = News::orderBy('created', 'desc')->paginate(10);

        return view('news.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new News;

        $data->created = $request->created;
        $data->title   = $request->title;
        $data->link    = $request->link;
        $data->tag     = $request->tag;

        $fileInfo = $request->file('filePath');
        if ($fileInfo) {
            $data->file_path = uploadFile($fileInfo, 'public/uploads/news');
        }

        $data->save();

        flash()->addSuccess('News add successful.');

        return redirect()->route('admin.news');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return News::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = News::find($request->id);

        $data->created = $request->created;
        $data->title   = $request->title;
        $data->link    = $request->link;
        $data->tag     = $request->tag;

        $fileInfo = $request->file('filePath');
        if ($fileInfo) {

            if (file_exists($data->file_path)) unlink($data->file_path);

            $data->file_path = uploadFile($fileInfo, 'public/uploads/news');
        }

        $data->save();

        flash()->addSuccess('News update successful.', 'Update');

        return redirect()->route('admin.news');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = News::find($id);

        if (file_exists($data->file_path)) unlink($data->file_path);

        $data->delete();

        flash()->addSuccess('News delete successful.', 'Delete');

        return redirect()->route('admin.news');
    }
}
