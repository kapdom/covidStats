<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Country;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CountryFactory
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * @param string $country
     * @param string $iso2Code
     * @param string $continent
     * @param int $population
     * @param array $coordiantes
     * @param string $flagUrl
     *
     * @return Country
     */
    public function createCountry(
        string $country,
        string $iso2Code,
        string $continent,
        int $population,
        array $coordiantes,
        string $flagUrl
    ): Country
    {
        return new Country(
            $country,
            $iso2Code,
            $continent,
            $population,
            $coordiantes,
            $flagUrl
        );
    }

    /**
     * @param array $data
     *
     * @return Country
     */
    public function createCountryFromArray(array $data): ?Country
    {
       try {
           $this->output->writeln($data['country'].': '.$data['countryInfo']['flag']);

            if (null === $data['countryInfo']['iso2'] || empty($data['countryInfo']['iso2'])) {
                return null;
            }

           return $this->createCountry(
               $data['country'],
               $data['countryInfo']['iso2'],
               $data['continent'],
               (int)$data['population'],
               ['lat' => $data['countryInfo']['lat'], 'lon' => $data['countryInfo']['long']],
               $data['countryInfo']['flag']
           );
       } catch (\Exception $e) {
           $this->output->writeln($e->getMessage());
       }

       return null;
    }
}
