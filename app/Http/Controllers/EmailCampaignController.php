<?php

namespace App\Http\Controllers;

use App\Models\EmailCamapignItems;
use App\Models\EmailCampaign;
use App\Models\EmailCategory;
use App\Models\EmailFrom;
use App\Models\EmailList;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmailCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['permission:mail my campaigns,admin'])->only('index');
        $this->middleware(['permission:mail my campaigns create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:mail my campaigns edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:mail my campaigns delete,admin'])->only('destroy');
        $this->data['activeMenu']    = 'mailBox';
        $this->data['activeSubMenu'] = 'emailCampaign';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['results'] = EmailCampaign::orderByDesc('id')->get();

        $this->data['pendingMail'] = DB::table('jobs')->count();
        $this->data['failedMail']  = DB::table('failed_jobs')->count();

        return view('mailbox.campaign.index', $this->data);
    }

    /**
     * Pending email.
     */
    public function pendingMail()
    {
        $this->data['pendingMail'] = DB::table('jobs')->count();
        $this->data['failedMail']  = DB::table('failed_jobs')->count();

        $this->data['results'] = DB::table('jobs')->paginate(100)->withQueryString();

        return view('mailbox.campaign.pending-mail', $this->data);
    }

    /**
     * Failed email.
     */
    public function failedMail()
    {
        $this->data['pendingMail'] = DB::table('jobs')->count();
        $this->data['failedMail']  = DB::table('failed_jobs')->count();

        $this->data['results'] = DB::table('failed_jobs')->paginate(100)->withQueryString();

        return view('mailbox.campaign.failed-mail', $this->data);
    }

    /**
     * Send email.
     */
    public function sendEmail($id = null)
    {
        Artisan::call('queue:work');

        flash()->addSuccess('Email send successful.');
        return redirect()->back();
    }


    /**
     * Retry email.
     */
    public function retryMail($id = null)
    {
        Artisan::call('queue:retry', ['id' => $id]);

        flash()->addSuccess('Email resend successful.');
        return redirect()->back();
    }

    /**
     * Retry all email.
     */
    public function retryAllMail()
    {
        Artisan::call('queue:retry all');

        flash()->addSuccess('All Email resend successful.');
        return redirect()->back();
    }

    /**
     * remove all email.
     */
    public function clearAllMail()
    {
        Artisan::call('queue:flush');

        flash()->addError('Remove all failed email.', 'Delete');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function failedDestroy($id)
    {
        DB::table('failed_jobs')->where('id', $id)->delete();

        flash()->addError('Failed email delete successful.', 'Delete');
        return redirect()->route('admin.email.failed');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $emailIdArray = array_map('intval', json_decode($request->email_ids, true));
        $template     = EmailTemplate::find($request->template_id);
        $emailFrom    = EmailFrom::find($request->email_from_id);

        $categoryName = ($request->email_category_id != 'all') ? EmailCategory::find($request->email_category_id)->name : 'All';

        $data                = new EmailCampaign;
        $data->created       = date('Y-m-d');
        $data->admin_id      = Auth::user()->id;
        $data->name          = $categoryName;
        $data->email_name    = $emailFrom->name;
        $data->email_from    = $emailFrom->email;
        $data->subject       = $template->subject;
        $data->template_name = $template->name;
        $data->template      = $template->description;
        $data->total_email   = count($emailIdArray);

        $data->save();

        $emailList = EmailList::whereIn('id', $emailIdArray)->get();
        if (!empty($emailIdArray)) {
            foreach ($emailIdArray as $emailId) {

                $itemInfo = new EmailCamapignItems;

                $itemInfo->email_campaign_id = $data->id;
                $itemInfo->email             = $emailList->where('id', $emailId)->first()->email;

                $itemInfo->save();
            }
        }

        return response()->json(['message' => 'Campaign create successful.', 'success' => true], 200);
    }

    /**
     * Display the specified resource.
     */
    public function success()
    {
        flash()->addSuccess('Campaign create successful.', 'Success');
        return redirect()->route('admin.email');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailCampaign $emailCampaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailCampaign $emailCampaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        EmailCampaign::find($id)->delete();

        EmailCamapignItems::where('email_campaign_id', $id)->delete();

        flash()->addSuccess('Campaign delete successful.', 'Delete');
        return redirect()->route('admin.email.campaign');
    }
}
