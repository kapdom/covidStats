<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\CountryCovid;

class Covid19ApiToCovidFactory extends AbstractCountryCovidFactory
{

    /**
     * @param array $countryData
     * @param string $hostCode
     *
     * @return array
     *
     * @throws \Exception
     */
    public function creatCovidFromArray(& $countryData, string $hostCode): array
    {
        $covidArray = [];
        $country = $this->countryNamesProvider->getDataByCountryName($countryData[0]['Country']);
        if (null === $country) {
            return $covidArray;
        }

        foreach ($countryData as $data) {
            $covidArray[] = (new CountryCovid())
                ->setHostCode($hostCode)
                ->setName($country->getName())
                ->setIso2($country->getIso2())
                ->setRecovered($data['Recovered'])
                ->setConfirmed($data['Confirmed'])
                ->setDeaths( $data['Deaths'])
                ->setDayDate(new \DateTime($data['Date']));
        }

        return $covidArray;
    }
}
