<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ApiDataStatus;
use App\Interfaces\ICovidFactory;
use App\Model\CovidModel;
use App\Repository\ApiDataStatusRepository;
use Doctrine\ORM\NonUniqueResultException;
use GuzzleHttp\Client;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractService
{
    /**
     * @var string
     */
    protected $hostUrl;

    /**
     * @var string
     */
    protected $allDataUrl;

    /**
     * @var string
     */
    protected $dailyUpdateUrl;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var ICovidFactory
     */
    protected $covidFactory;

    /**
     * @var CovidModel[]
     */
    protected $covidModelCollection = [];

    /**
     * @var ApiDataStatus|null
     */
    protected $apiDataStatus;

    /**
     * AbstractService constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->output = new ConsoleOutput();
    }


    /**
     * @required
     *
     * @param ApiDataStatusRepository $apiDataStatusRepository
     *
     * @throws NonUniqueResultException
     */
    final public function loadApiDataStatus(ApiDataStatusRepository $apiDataStatusRepository): void
    {
        $this->apiDataStatus = $apiDataStatusRepository->findOneBySomeField($this->getHostCode());
    }

    /**
     * @return string
     */
    public function getHostUrl(): string
    {
        return $this->hostUrl;
    }

    /**
     * @return string
     */
    public function getAllDataUrl(): string
    {
        return $this->allDataUrl;
    }

    /**
     * @return string
     */
    public function getDailyUpdateUrl(): string
    {
        return $this->dailyUpdateUrl;
    }

    /**
     *
     * @return self
     */
    abstract public function downloadAllStatisticData(): self;

    /**
     * @return string
     */
    abstract public function getHostCode(): string;

    /**
     * @return CovidModel[]
     */
    public function getCovidModelCollection(): array
    {
        return $this->covidModelCollection;
    }

    /**
     * @return ApiDataStatus
     */
    public function getApiStatusData(): ?ApiDataStatus
    {
        return $this->apiDataStatus;
    }

    /**
     * @return bool
     */
    final public function isDataExistInDb(): bool
    {
        return null !== $this->apiDataStatus && $this->apiDataStatus->getStatus() === ApiDataStatus::STATUS_DONE;
    }

}
