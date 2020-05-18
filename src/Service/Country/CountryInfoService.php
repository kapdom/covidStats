<?php

declare(strict_types=1);

namespace App\Service\Country;

use GuzzleHttp\Client;

class CountryInfoService
{
    /**
     * @var string
     */
    private $hostName = 'https://corona.lmao.ninja';

    /**
     * @var string
     */
    private $dataUrl = '/v2/countries';

    /**
     * @var Client
     */
    private $client;

    /**
     * CountryInfoService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array|null
     */
    public function getCountryData(): ?array
    {
        $response = $this->client->get($this->hostName.$this->dataUrl);

        if ((string)$response->getStatusCode() === '200') {
            $body = $response->getBody()->getContents();

            return json_decode($body, true);
        }

        return null;
    }
}
