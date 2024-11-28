<?php

namespace App\Console\Commands;

use App\Models\CustomJobs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CustomJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:custom-job-send-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a custom job email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = CustomJobs::where('status', 'pending')->orderBy('queue')->orderBy('id')->take(5)->get();
        if (!empty($emails)) {
            foreach ($emails as $email) {

                DB::transaction(function () use ($email) {
                    try {

                        $dataList = json_decode($email->details);

                        $mailData = [];
                        if(!empty($dataList)){
                            foreach ($dataList as $key => $value){
                                $mailData[$key] = [$value];
                            }
                        }

                        $mailData = [
                            'invoiceInfo' => $dataList->invoiceInfo,
                            'orderInfo'   => $dataList->orderInfo,
                        ];

                        // Send the email
                        sendMail()->send($email->from, $email->to, $email->subject, $mailData, $email->template);

                        // Delete email record after successful send
                        $email->delete();

                        $this->info("Email sent to {$email->to}");
                    } catch (\Exception $e) {

                        // Increment attempts and update error within a transaction
                        $email->update([
                            'status'   => 'failed',
                            'attempts' => DB::raw('attempts + 1'),
                            'error'    => $e->getMessage(),
                        ]);

                        $this->error("Failed to send email to {$email->to}: {$e->getMessage()}");
                    }
                });
            }
        } else {
            $this->info("Jobs not found!");
        }
    }
}
