<?php

declare(strict_types=1);

namespace App\Process;

use App\Entity\ApiDataStatus;
use App\Entity\CountryCovid;
use App\Service\AbstractService;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CovidDataProcessor
{
    /**
     * @var OutputInterface
     */
    public $output;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CovidDataProcesor constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->output = new ConsoleOutput();
        $this->entityManager = $entityManager;
    }

    /**
     * @param AbstractService $service
     *
     * @return void
     */
    public function processAllPastData(AbstractService $service): void
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        if (!$service->isDataExistInDb()) {
            $apiStatus = $service->getApiStatusData();
            if (null === $apiStatus) {
                $apiStatus = $this->initDataStatus($service);
            }

            $apiStatus->setStatus(ApiDataStatus::STATUS_IN_PROGRESS);
            $this->entityManager->flush();
            $covidEntityArray = $service->downloadAllStatisticData()->getCovidModelCollection();

            try {
                $this->entityManager->beginTransaction();
                if (!empty($covidEntityArray)) {
                    $this->storeStatsInDb($covidEntityArray, $service->getHostUrl());
                }
                $apiStatus->setStatus(ApiDataStatus::STATUS_DONE);
                $this->entityManager->flush();
                $this->entityManager->commit();
            } catch (\Exception $exception) {
                $this->entityManager->rollback();

                $apiStatus->setStatus(ApiDataStatus::STATUS_FAIL);
                $this->entityManager->flush();

                $this->output->writeln('ERROR: Statistic from '.$service->getHostUrl().' has not been save in DB. '.$exception->getMessage());
            }
        } else {
            $this->output->writeln('Data from '.$service->getHostUrl().' is already in DB.');
        }

        $this->entityManager->clear();
    }

    /**
     * @param array $covidEntityArray
     * @param string $host
     * @throws DBALException
     */
    private function storeStatsInDb(array $covidEntityArray, string $host): void
    {
        $sql = 'INSERT INTO country_covid(id, name, iso2, confirmed, deaths, recovered, day_date, host_code, created_at)
                    VALUES (DEFAULT, :name, :iso2, :confirmed, :deaths, :recovered, :dayData, :hostCode, CURRENT_TIMESTAMP)';
        /** @var CountryCovid $covidEntity */
        foreach ($covidEntityArray as $covidEntity) {
            $conn = $this->entityManager->getConnection();
            $stm = $conn->prepare($sql);
            $stm->execute([
                'name' => $covidEntity->getName(),
                'iso2' => $covidEntity->getIso2(),
                'confirmed' => $covidEntity->getConfirmed(),
                'deaths' => $covidEntity->getDeaths(),
                'recovered' => $covidEntity->getRecovered(),
                'dayData' => $covidEntity->getDayDate()->format('Y-m-d'),
                'hostCode' => $covidEntity->getHostCode()
            ]);

        }
    }

    /**
     * @param AbstractService $service
     *
     * @return ApiDataStatus
     */
    private function initDataStatus(AbstractService $service): ApiDataStatus
    {
        $apiDataStatus = new ApiDataStatus();
        $apiDataStatus->setDataType(ApiDataStatus::DATA_TYPE_ALL);
        $apiDataStatus->setHostName($service->getHostCode());
        $this->entityManager->persist($apiDataStatus);

        return $apiDataStatus;
    }
}
