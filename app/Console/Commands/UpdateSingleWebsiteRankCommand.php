<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteList;

class UpdateSingleWebsiteRankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-single-website-rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update single website rand command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $websiteList = SiteList::select('api_site_id')->where('da', 0)->where('pa', 0)
                        ->where('auto_update', 1)->whereNotNull('api_site_id')->get();
        
        if(!empty($websiteList)){
            foreach($websiteList as $row){
                rankWebsite()->updateSingleWebsiteRank($row['api_site_id']);
            }
        }
    }
}
