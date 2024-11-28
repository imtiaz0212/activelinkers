<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['activeMenu'] = 'notice';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = Notice::orderBy('created', 'desc')->paginate(10);

        return view('notice.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new Notice;

        $data->created = $request->created;
        $data->title   = $request->title;

        $fileInfo = $request->file('attachFile');
        if ($fileInfo) {
            $data->file_path = uploadFile($fileInfo, 'public/uploads/notice');
        }

        $data->save();

        flash()->addSuccess('Notice add successful.');

        return redirect()->route('admin.notice');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Notice::find($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = Notice::find($request->id);

        $data->created = $request->created;
        $data->title   = $request->title;

        $fileInfo = $request->file('attachFile');
        if ($fileInfo) {

            if (file_exists($data->file_path)) unlink($data->file_path);

            $data->file_path = uploadFile($fileInfo, 'public/uploads/notice');
        }

        $data->save();

        flash()->addSuccess('Notice update successful.', 'Update');

        return redirect()->route('admin.notice');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Notice::find($id);

        if (file_exists($data->file_path)) unlink($data->file_path);

        $data->delete();

        flash()->addSuccess('Notice delete successful.', 'Delete');

        return redirect()->route('admin.notice');
    }
}
