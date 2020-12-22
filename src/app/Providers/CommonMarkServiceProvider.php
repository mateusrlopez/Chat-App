<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\InlinesOnly\InlinesOnlyExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;

class CommonMarkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $configuration = [
            'allow_unsafe_link' => false, 
            'html_input' => 'escape'
        ];
        
        $enviroment = new Environment($configuration);
        $enviroment->addExtension(new AutolinkExtension);
        $enviroment->addExtension(new InlinesOnlyExtension);
        $enviroment->addExtension(new StrikethroughExtension);

        $this->app->singleton(CommonMarkConverter::class, fn() => new CommonMarkConverter([], $enviroment));
    }
}
