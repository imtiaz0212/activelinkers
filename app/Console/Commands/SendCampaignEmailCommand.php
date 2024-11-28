<?php

namespace App\Console\Commands;

use App\Jobs\CampaignMailJob;
use App\Models\EmailCamapignItems;
use App\Models\EmailCampaign;
use Illuminate\Console\Command;

class SendCampaignEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'command:send-campaign-email-list';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Send 50 email after 1 minute.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailList = EmailCamapignItems::where('status', 0)->orderBy('id')->limit(50)->get();
        if (!empty($emailList) && $emailList->isNotEmpty()) {

            $campaignInfo = EmailCampaign::where('id', $emailList[0]->email_campaign_id)->first();

            if (!empty($campaignInfo)) {
                $data = [
                    'subject'  => $campaignInfo->subject,
                    'template' => $campaignInfo->template,
                ];

                $campaignInfo=[
                    'name' =>  $campaignInfo->email_name,
                    'email' =>  $campaignInfo->email_from
                ];

                foreach ($emailList as $row) {
                    $data = array_merge($data, ['email' => $row->email]);

                    CampaignMailJob::dispatch($data, $campaignInfo);
                    //CampaignMailJob::dispatch($data, $campaignInfo)->onQueue('campaign');
                }

                EmailCamapignItems::where('status', 0)->limit(50)->update(['status' => 1]);

                echo 'Email send successful.';
            }else{
                echo 'Campaign not found.';
            }
        }else{
            echo 'Email list is empty.';
        }
    }
}
