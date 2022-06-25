<?php
/**
 * Created by PhpStorm.
 * User: rocky
 * Date: 2022-06-21
 * Time: 18:00
 */

namespace ExAdmin\thinkphp;


use Symfony\Component\Console\Input\InputOption;
use think\migration\command\migrate\Rollback;

class MigrateRollback extends Rollback
{
    protected function configure()
    {
        $this->setName('admin:migrate:rollback')
            ->setDescription('Rollback the last or to a specific migration')
            ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to rollback to')
            ->addOption('--date', '-d', InputOption::VALUE_REQUIRED, 'The date to rollback to')
            ->addOption('--force', '-f', InputOption::VALUE_NONE, 'Force rollback to ignore breakpoints')
            ->setHelp(<<<EOT
The <info>migrate:rollback</info> command reverts the last migration, or optionally up to a specific version

<info>php think migrate:rollback</info>
<info>php think migrate:rollback -t 20111018185412</info>
<info>php think migrate:rollback -d 20111018</info>
<info>php think migrate:rollback -v</info>

EOT
            );
    }
    protected function getPath()
    {
        return plugin()->thinkphp->getPath() .DIRECTORY_SEPARATOR. 'database' . DIRECTORY_SEPARATOR . 'migrations';
    }
}