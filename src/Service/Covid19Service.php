<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\Covid19ApiToCovidFactory;
use App\Repository\ApiDataStatusRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Covid19Service extends AbstractService
{
    public const HOST_CODE = 'COVID_19_API';

    /**
     * @var string
     */
    protected $hostUrl = 'https://api.covid19api.com';

    /**
     * @var string
     */
    protected $allDataUrl = '/total/country/%s';

    /**
     * @var string
     */
    protected $dailyUpdateUrl = '/summary';

    /**
     * @var string
     */
    private $countryNameDetails = '/countries';


    /**
     * Covid19Model constructor.
     *
     * @param Client $client
     * @param Covid19ApiToCovidFactory $covid19ApiToCovidFactory
     */
    public function __construct(
        Client $client,
        Covid19ApiToCovidFactory $covid19ApiToCovidFactory
    )
    {
        $this->covidFactory = $covid19ApiToCovidFactory;
        parent::__construct($client);
    }

    public function getHostCode(): string
    {
        return self::HOST_CODE;
    }

    /**
     * @return self
     *
     * @throws \Exception
     */
    public function downloadAllStatisticData(): AbstractService
    {
        $countries = $this->getCountriesNameDetails();

        foreach ($countries as $country) {

            $this->output->writeln('Process for country: '.$country['Country']);
            try {
                $response = $this->client->get($this->hostUrl . sprintf($this->allDataUrl, $country['Slug']));
                if ($response->getStatusCode() !== 200) {
                    $this->output->writeln('Unable to download data for: ' . $country['Country']);
                    continue;
                }

                $countryData = json_decode($response->getBody()->getContents(), true);

                if (!empty($countryData)) {
                    $this->covidModelCollection[] = $this->covidFactory->creatCovidFromArray($countryData, self::HOST_CODE);
                }

                unset($countryData);

            } catch (BadResponseException  $e) {
                $this->output->writeln('Unable to download data for: ' . $country['Country'] . ': ' . $e->getMessage());
            }

            //sleep(1);
        }

        $this->covidModelCollection = array_merge(...$this->covidModelCollection);
        return $this;
    }

    /**
     * @return array|null
     */
    private function getCountriesNameDetails(): array
    {
        $response = $this->client->get($this->hostUrl.$this->countryNameDetails);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), true);
        }

        return [];
    }
}
