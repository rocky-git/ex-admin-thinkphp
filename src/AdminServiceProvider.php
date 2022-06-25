<?php

namespace ExAdmin\thinkphp;



use ExAdmin\thinkphp\command\InstallCommand;
use ExAdmin\thinkphp\command\PluginComposerCommand;
use ExAdmin\ui\support\Container;
use think\Service;

class AdminServiceProvider extends Service
{
   
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Container::getInstance()->plugin->register();
    }
   
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        config(['default_route_pattern'=>'[\-\w\.]+'],'route');
        
        $this->commands([
            MigrateRollback::class,
            MigrateRun::class,
            SeedRun::class,
            InstallCommand::class,
            PluginComposerCommand::class
        ]);
    }
}
