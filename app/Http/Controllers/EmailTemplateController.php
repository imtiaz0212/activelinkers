<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['permission:mail email templates,admin'])->only('index');
        $this->middleware(['permission:mail email templates create template,admin'])->only(['create','store']);
        $this->middleware(['permission:mail email templates edit,admin'])->only(['edit','update']);
        $this->middleware(['permission:mail email templates delete,admin'])->only('destroy');

        $this->data['activeMenu']    = 'mailBox';
        $this->data['activeSubMenu'] = 'emailTemplate';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = EmailTemplate::orderBy('position')->get();


        return view('mailbox.template.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mailbox.template.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new EmailTemplate;

        $data->name        = $request->name;
        $data->subject     = $request->subject;
        $data->description = $request->description;

        $data->save();

        flash()->addSuccess('Email Template added successfully');

        return redirect()->route('admin.email.template');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $this->data['info'] = EmailTemplate::find($id);

        return view('mailbox.template.edit', $this->data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = EmailTemplate::find($id);

        $data->name        = $request->name;
        $data->subject     = $request->subject;
        $data->description = $request->description;

        $data->save();

        flash()->addSuccess('Email Template Updated successfully.');

        return redirect()->route('admin.email.template');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = EmailTemplate::find($id);
        $data->delete();

        flash()->addSuccess('Email Template deleted successfully.', 'Delete');

        return redirect()->back();
    }
}
