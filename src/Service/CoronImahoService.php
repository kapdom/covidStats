<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\CoronaDataToCovidFactory;
use App\Provider\CountryNamesProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class CoronImahoService extends AbstractService
{

    public const HOST_CODE = 'CORONA_IMAO';

    /**
     * @var string
     */
    protected $hostUrl = 'https://corona.lmao.ninja';

    /**
     * @var string
     */
    protected $allDataUrl = '/v2/historical/%s?lastdays=1000';

    /**
     * @var string
     */
    protected $dailyUpdateUrl = '/v2/historical?lastdays=1';

    /**
     * @var CountryNamesProvider
     */
    private $countryNamesProvider;

    /**
     * Covid19Model constructor.
     *
     * @param Client $client
     * @param CoronaDataToCovidFactory $coronaDataToCovidFactory
     * @param CountryNamesProvider $countryNamesProvider
     */
    public function __construct(
        Client $client,
        CoronaDataToCovidFactory $coronaDataToCovidFactory,
        CountryNamesProvider $countryNamesProvider)
    {
        $this->covidFactory = $coronaDataToCovidFactory;
        $this->countryNamesProvider = $countryNamesProvider;
        parent::__construct($client);
    }

    /**
     * @return string
     */
    public function getHostCode(): string
    {
        return self::HOST_CODE;
    }

    /**
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function downloadAllStatisticData(): AbstractService
    {
        foreach ($this->countryNamesProvider->getCountries() as $country) {
            $this->output->writeln('Process for country: '.$country->getName());
            try {
                $response = $this->client->get($this->hostUrl . sprintf($this->allDataUrl, $country->getIso2()));

                if ($response->getStatusCode() !== 200) {
                    $this->output->writeln('Unable to download data for: ' . $country->getName());
                    continue;
                }

                $countryData = json_decode($response->getBody()->getContents(), true);

                if (!empty($countryData)) {
                    $this->covidModelCollection[] = $this->covidFactory->creatCovidFromArray($countryData, self::HOST_CODE);
                }

            } catch (BadResponseException  $e) {
                $this->output->writeln('Unable to download data for: ' . $country->getName().': '.$e->getMessage());
            }
            unset($countryData);

            //sleep(1);
        }
        $this->covidModelCollection = array_merge(...$this->covidModelCollection);
        return $this;
    }
}
