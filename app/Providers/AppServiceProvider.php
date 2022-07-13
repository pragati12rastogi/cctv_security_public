<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\SocialMediaSetting;
use App\Models\Banner;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $data = [];

        $general_settings =  GeneralSetting::first();
        $social_icons     =  SocialMediaSetting::where('path',"<>",NULL)->where('path',"<>",'')->get();
        $banner_settings  =  Banner::first();
        

        $data = array(
            'general_settings' => $general_settings,
            'social_icons'     => $social_icons,
            'banner_settings'  => $banner_settings
           
        );
        view()->composer('*', function ($view) use ($data) {

            try {
                $view->with([
                    
                    'general_settings' => $data['general_settings'],
                    'social_icons'     => $data['social_icons'],
                    'banner_settings'  => $data['banner_settings'],
                    
                ]);

            } catch (\Exception $e) {

            }

        });
    }
}
