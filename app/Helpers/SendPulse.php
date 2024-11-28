<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class SendPulse
{
    protected $sendPulseUserId;
    protected $sendPulseSecret;
    protected $sendPulseAttachment;

    public function __construct()
    {
        $this->sendPulseUserId     = config('services.sendpulse_api_user_id');
        $this->sendPulseSecret     = config('services.sendpulse_api_secret');
        $this->sendPulseAttachment = storage_path() . "/sendPulseAttachment/";
    }

    public function send($emailFrom = null, $emailTo = null, $subject = null, $data = null, $template = null)
    {

        if (empty($emailFrom)) {
            throw new \InvalidArgumentException('The "emailFrom" parameter is required.');
        }

        if (empty($emailTo)) {
            throw new \InvalidArgumentException('The "emailTo" parameter is required.');
        }

        if (empty($subject)) {
            throw new \InvalidArgumentException('The "subject" parameter is required.');
        }

        if (empty($data)) {
            throw new \InvalidArgumentException('The "data" parameter is required.');
        }

        if (empty($template)) {
            throw new \InvalidArgumentException('The "template" parameter is required.');
        }

        // Ensure the attachment directory exists
        if (!is_dir($this->sendPulseAttachment)) {
            if (!mkdir($this->sendPulseAttachment, 0755, true) && !is_dir($this->sendPulseAttachment)) {
                throw new \InvalidArgumentException("Failed to create directory: {$this->sendPulseAttachment}");
            }
        }

        $apiClient    = new ApiClient($this->sendPulseUserId, $this->sendPulseSecret, new FileStorage($this->sendPulseAttachment));
        $emailToList  = is_array($emailTo) ? array_map(fn($email) => ['name' => '', 'email' => $email], $emailTo) : [['name' => '', 'email' => $emailTo]];
        $data         = (is_array($data) ? $data : ['data' => $data]);
        $emailContent = [
            'html'    => view($template, $data)->render(),
            'text'    => getSiteInfo()->site_name,
            'subject' => $subject,
            'from'    => [
                'name'  => getSiteInfo()->site_name,
                'email' => $emailFrom,
            ],
            'to'      => $emailToList,
        ];

        // Send the email
        try {
            return $apiClient->smtpSendMail($emailContent);
        } catch (Exception $e) {
            // Log error and rethrow for further handling
            Log::error("Failed to send email: " . $e->getMessage());
            throw $e;
        }
    }
}
