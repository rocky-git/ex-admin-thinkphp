<?php

namespace ExAdmin\thinkphp;

use ExAdmin\thinkphp\command\InstallCommand;
use ExAdmin\thinkphp\command\MigrateRollback;
use ExAdmin\thinkphp\command\MigrateRun;
use ExAdmin\thinkphp\command\PluginComposerCommand;
use ExAdmin\thinkphp\command\SeedRun;
use ExAdmin\thinkphp\exception\Error;
use ExAdmin\ui\support\Container;
use Symfony\Component\Filesystem\Filesystem;
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
        set_error_handler([$this->app->make(Error::class), 'appError']);
        Container::getInstance()->plugin->register();
        $this->updateVersion();
    }
    
    protected function updateVersion(){
        $file = public_path('exadmin').DIRECTORY_SEPARATOR.'version';
        $update = false;
        if(!is_file($file)){
            $update = true;
        }
        if(!$update && file_get_contents($file) != ex_admin_version()){
            $update = true;
        }
        if($update){
            $filesystem = new Filesystem();
            $filesystem->mirror(dirname(__DIR__,2) . '/ex-admin-ui/resources',public_path('exadmin'),null,['override'=>true]);
            file_put_contents($file,ex_admin_version());
        }
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
