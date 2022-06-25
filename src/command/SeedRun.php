<?php
/**
 * Created by PhpStorm.
 * User: rocky
 * Date: 2022-06-21
 * Time: 18:07
 */

namespace ExAdmin\thinkphp\command;


use Symfony\Component\Console\Input\InputOption;
use think\migration\command\seed\Run;

class SeedRun extends Run
{
    protected function configure()
    {

        $this->setName('admin:seed:run')
            ->setDescription('Run database seeders')
            ->addOption('--seed', '-s', InputOption::VALUE_REQUIRED, 'What is the name of the seeder?')
            ->setHelp(<<<EOT
                The <info>seed:run</info> command runs all available or individual seeders

<info>php think seed:run</info>
<info>php think seed:run -s UserSeeder</info>
<info>php think seed:run -v</info>

EOT
            );
    }
    protected function getPath()
    {
        return plugin()->thinkphp->getPath() .DIRECTORY_SEPARATOR. 'database' . DIRECTORY_SEPARATOR . 'seeds';
    }
}