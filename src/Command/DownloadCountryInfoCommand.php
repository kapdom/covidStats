<?php

namespace App\Command;

use App\Command\Executor\DownloadCountryInfoExecutor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCountryInfoCommand extends Command
{
    protected static $defaultName = 'country:download:info';

    /**
     * @var DownloadCountryInfoExecutor
     */
    private $executor;

    public function __construct(DownloadCountryInfoExecutor $countryInfoExecutor, string $name = null)
    {
        $this->executor = $countryInfoExecutor;
        parent::__construct($name);
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Download and save in db country info data ');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $this->executor->execute($output);

       return 1;
    }
}
