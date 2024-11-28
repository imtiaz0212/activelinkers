<?php

namespace App\Http\Controllers;

use App\Models\EmailFrom;
use Illuminate\Http\Request;

class EmailFromController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['permission:mail email froms,admin'])->only('index');
        $this->middleware(['permission:mail email froms create new,admin'])->only('store');
        $this->middleware(['permission:mail email froms edit,admin'])->only(['edit','update']);
        $this->middleware(['permission:mail email froms delete,admin'])->only('destroy');

        $this->data['activeMenu']    = 'mailBox';
        $this->data['activeSubMenu'] = 'emailFrom';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = EmailFrom::all();

        return view('mailbox.email-from', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new EmailFrom;

        $data->name = $request->name;
        $data->email = $request->email;

        $data->save();

        flash()->addSuccess('Email from add successful.');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        if (!empty($request->id)) {
            return EmailFrom::find($request->id);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = EmailFrom::find($request->id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->status = $request->status;

        $data->save();

        flash()->addSuccess('Email from update successful.', 'Update');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = EmailFrom::find($id);
        $data->delete();

        flash()->addSuccess('Email from delete successful.', 'Delete');

        return redirect()->back();
    }
}
