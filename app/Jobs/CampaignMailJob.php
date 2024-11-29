<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CampaignMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $emailFrom;
    public $emailName;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $campaignInfo = [])
    {
        $this->data = (object)$data;
        $this->emailFrom = (!is_array($campaignInfo) && isset($campaignInfo['email']) ? $campaignInfo['email'] : config('app.mail_from_address'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sendMail()->send($this->emailFrom, $this->data->email, $this->data->subject, $this->data, 'mail.campaign');
        //Mail::to($this->data->email)->send(new SendCampaignMail($this->data, $this->emailFrom));
    }
}
