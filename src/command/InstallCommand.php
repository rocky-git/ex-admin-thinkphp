<?php
declare (strict_types = 1);

namespace ExAdmin\thinkphp\command;

use Symfony\Component\Filesystem\Filesystem;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Console;
use think\facade\Db;

class InstallCommand extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('admin:install')
            ->setDescription('Install the admin package');
        $this->addOption('force', 'f', Option::VALUE_NONE, 'Force overwrite file');
        $this->addOption('versions', null, Option::VALUE_REQUIRED, 'version number');
        $this->addOption('username', null, Option::VALUE_REQUIRED, 'username');
        $this->addOption('password', null, Option::VALUE_REQUIRED, 'password');
    }

    protected function execute(Input $input, Output $output)
    {


        $filesystem = new Filesystem;
        $filesystem->mirror(__DIR__ . '/../../../ex-admin-ui/resources',public_path('ex-admin'),null,['override'=>$input->hasOption('force')]);
       
        $path = plugin()->download('thinkphp',$input->getOption('versions'));
        if ($path === false) {
            $this->output->warning('下载插件失败');
            return 0;
        }
        $result = plugin()->install($path,$input->hasOption('force'));
        if ($result !== true) {
            $this->output->warning($result);
            return 0;
        }
        unlink($path);
        plugin()->buildIde();
        plugin()->thinkphp->install();
        $username = $input->getOption('username');
        $password = $input->getOption('password');
        if($username && $password){
            $table = plugin()->thinkphp->config('database.user_table');
            Db::name($table)->where('id',1)
                ->update([
                    'username' => $username,
                    'password' => password_hash($password,PASSWORD_DEFAULT),
                ]);
        }
        $output->writeln(Console::call('plugin:composer',['thinkphp'])->fetch());
        
        // 指令输出
        $output->writeln('install success');
    }
}
