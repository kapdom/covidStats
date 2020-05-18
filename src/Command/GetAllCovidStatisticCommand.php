<?php

namespace App\Command;

use App\Command\Executor\GetAllCovidStatisticExecutor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAllCovidStatisticCommand extends Command
{
    protected static $defaultName = 'covid:stats:all';

    /**
     * @var GetAllCovidStatisticExecutor
     */
    private $executor;

    /**
     * GetAllCovidStatisticCommand constructor.
     * @param GetAllCovidStatisticExecutor $getAllCovidStatisticExecutor
     * @param string|null $name
     */
    public function __construct(GetAllCovidStatisticExecutor $getAllCovidStatisticExecutor, string $name = null)
    {
        $this->executor = $getAllCovidStatisticExecutor;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Get all statistic from all configured servers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->executor->execute($output);
        return 1;
    }
}
