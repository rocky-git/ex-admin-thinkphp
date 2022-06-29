<?php
declare (strict_types = 1);

namespace ExAdmin\thinkphp\command;

use Symfony\Component\Process\Process;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class PluginComposerCommand extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('plugin:composer')
            ->setDescription('Install the plugin package');
        $this->addArgument('name',Argument::OPTIONAL,'plugin name');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = $input->getArgument('name');
        $plugs = plugin()->getPlug($name);
        if(!is_array($plugs)){
            $plugs = [$plugs];
        }
        $package = [];
        foreach ($plugs as $plug){
            $requires = $plug['require'] ??[];
            foreach ($requires as $require=>$version){
                $package[] = $require;
                $package[] = $version;
            }
        }
        if(count($package) == 0){
            $output->write('Nothing to install, update or remove');
            return 0;
        }
        $path  = dirname(__DIR__,5);
        $cmd = array_merge(['composer','require'],$package);
        $process = new Process($cmd,$path);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
    }
}
