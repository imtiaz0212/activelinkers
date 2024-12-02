<?php

namespace App\Http\Controllers;

use App\Models\EmailCategory;
use App\Models\EmailFrom;
use App\Models\EmailList;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['permission:mail mailing lists,admin'])->only('index');
        $this->middleware(['permission:mail mailing lists create new,admin'])->only('store');
        $this->middleware(['permission:mail mailing lists import csv,admin'])->only('storeCsv');
        $this->middleware(['permission:mail mailing lists edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:mail mailing lists delete,admin'])->only('destroy');

        $this->data['activeMenu']        = 'mailBox';
        $this->data['activeSubMenu']     = 'emailList';
        $this->data['emailCategoryList'] = EmailCategory::categoryList();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['emailTemplateList'] = EmailTemplate::templateList('', [1, 2, 3, 9]);
        $this->data['emailFromList']     = EmailFrom::emailList();

        if ($request->ajax()) {
            return EmailList::searchEmailList($request);
        }

        return view('mailbox.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = EmailList::where('email', $request->email)->first();
        if (!empty($data)) {

            flash()->addError('This email already exists.');
            return redirect()->back();

        } else {

            $data = new EmailList;

            $data->email_category_id = $request->email_category_id;
            $data->email             = $request->email;
            $data->from              = 'insert';

            $data->save();
        }

        flash()->addSuccess('Email add successful.');
        return redirect()->route('admin.email');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeCsv(Request $request)
    {
        $file = $request->file('csv_file');

        $count           = 1;
        $uniqueCount     = $duplicateCount = 0;
        $emailList       = EmailList::select('email')->get();
        $createAt        = date('Y-m-d H:i:s');
        $emailCategoryId = $request->email_category_id;

        $results = [];
        if ($file->getSize() > 10) {
            $handle = fopen($file, "r");
            if (empty($handle) === false) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($count != 1) {
                        if (empty($emailList->where('email', $data[0])->first())) {
                            $results[] = ['email_category_id' => $emailCategoryId, 'email' => $data[0], 'from' => 'csv', 'created_at' => $createAt, 'updated_at' => $createAt];
                            $uniqueCount++;
                        } else {
                            $duplicateCount++;
                        }
                    }
                    $count++;
                }
                fclose($handle);
            }
        }

        if (count($results) > 0) {

            flash()->addSuccess("Email add successful. <br> Unique email: {$uniqueCount} <br> Duplicate email: {$duplicateCount}");

            EmailList::insert($results);

            return redirect()->route('admin.email');
        }

        flash()->addError('Data not found.');
        return redirect()->route('admin.email');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        if (!empty($request->id)) {
            return EmailList::find($request->id);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = EmailList::where('email', $request->email)->where('id', '!=', $request->id)->first();
        if (!empty($data)) {

            flash()->addError('This email already exists.');
            return redirect()->route('admin.email');

        } else {

            $data = EmailList::find($request->id);

            $data->email_category_id = $request->email_category_id;
            $data->email             = $request->email;
            $data->status            = $request->status;

            $data->save();
        }

        flash()->addSuccess('Email update successful.');
        return redirect()->route('admin.email');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = EmailList::find($id);
        $data->delete();
        flash()->addSuccess('Email delete successful.', 'Delete');
        return redirect()->back();
    }
}
