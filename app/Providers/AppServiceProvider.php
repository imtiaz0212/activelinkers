<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::defaultView('pagination::default');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* site info */
        view()->share('siteInfo', getSiteInfo());

        /* cta info */
        $ctaInfo = getSectionData()->where('page', 'home')->where('section', 'cta')->first();
        $ctaInfo = (!empty($ctaInfo->content) ? json_decode($ctaInfo->content) : '');
        view()->share('ctaInfo', $ctaInfo);
    }
}
