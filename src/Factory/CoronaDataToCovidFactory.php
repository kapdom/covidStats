<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\CountryCovid;

class CoronaDataToCovidFactory extends AbstractCountryCovidFactory
{
    /**
     * @param array $countryData
     * @param string $hostCode
     *
     * @return array
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function creatCovidFromArray(& $countryData, string $hostCode): array
    {
        $covidArray= [];
        $countryDetails = $this->countryNamesProvider->getDataByCountryName($countryData['country']);
        if (null !== $countryDetails) {

            $timeLine = $countryData['timeline'];

            foreach ($timeLine['cases'] as $key => $data) {
                $covidArray[] = (new CountryCovid())
                    ->setHostCode($hostCode)
                    ->setIso2($countryDetails->getIso2())
                    ->setName($countryData['country'])
                    ->setConfirmed($timeLine['cases'][$key])
                    ->setDeaths( $timeLine['deaths'][$key])
                    ->setRecovered($timeLine['recovered'][$key])
                    ->setDayDate(\DateTime::createFromFormat('n/j/y', $key));
            }
        }

        return $covidArray;
    }
}
