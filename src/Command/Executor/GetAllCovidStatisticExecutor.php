<?php

declare(strict_types=1);

namespace App\Command\Executor;

use App\Handler\ApiServiceHandler;
use App\Process\CovidDataProcessor;
use App\Service\AbstractService;
use Symfony\Component\Console\Output\OutputInterface;

class GetAllCovidStatisticExecutor
{
    /**
     * @var CovidDataProcessor
     */
    private $covidDataProcessor;

    /**
     * @var ApiServiceHandler
     */
    private $apiServiceHandler;

    /**
     * GetAllCovidStatisticExecutor constructor.
     *
     * @param CovidDataProcessor $covidDataProcessor
     * @param ApiServiceHandler $apiServiceHandler
     */
    public function __construct(CovidDataProcessor $covidDataProcessor, ApiServiceHandler $apiServiceHandler)
    {
        $this->covidDataProcessor = $covidDataProcessor;
        $this->apiServiceHandler = $apiServiceHandler;
    }

    /**
     * @param OutputInterface $output
     */
    public function execute(OutputInterface $output): void
    {
        /** @var AbstractService $service */
        foreach ($this->apiServiceHandler->getServices() as $service) {
            $start = microtime(true);
            $output->writeln('Start processing  all data from: '.$service->getHostUrl());
            try {
                $this->covidDataProcessor->processAllPastData($service);
                $end = microtime(true);
                $output->writeln('Finish processing all data from: '.$service->getHostUrl().' in'.($end-$start).' seconds.');
            } catch (\Exception $e) {
                $output->writeln('Error processing all data from: '.$service->getHostUrl().' '.$e->getMessage());
            }
        }
    }
}
