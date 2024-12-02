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
    protected $description = 'Send 40 email after 1 minute.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailList = EmailCamapignItems::where('status', 0)->orderBy('id')->limit(50)->get();

        $groupedByCampaign = $emailList->groupBy('email_campaign_id');

        if (!empty($groupedByCampaign)) {
            foreach ($groupedByCampaign as $email_campaign_id => $emails) {

                $campaignInfo = EmailCampaign::where('id', $email_campaign_id)->first();

                if (!empty($campaignInfo)) {

                    $campaignInfo->increment('total_send', $emails->count());

                    $data = [
                        'subject'  => $campaignInfo->subject,
                        'template' => $campaignInfo->template,
                    ];

                    $campaignInfo = [
                        'name'  => $campaignInfo->email_name,
                        'email' => $campaignInfo->email_from
                    ];

                    foreach ($emails as $row) {
                        $data = array_merge($data, ['email' => $row->email]);

                        CampaignMailJob::dispatch($data, $campaignInfo);
                    }

                    EmailCamapignItems::whereIn('id', $emails->pluck('id'))->update(['status' => 1]);

                    $this->info('Email send successful.');
                }else{
                    $this->info('Campaign not found.');
                }
            }
        }

        $this->info('Email list is empty.');
    }
}
