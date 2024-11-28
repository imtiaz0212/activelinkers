<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateWebsiteRankCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'command:update-website-rank';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Update all website rank';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        rankWebsite()->updateWebsiteRank();
    }
}
