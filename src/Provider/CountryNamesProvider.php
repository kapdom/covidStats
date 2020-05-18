<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class CountryNamesProvider
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var FilesystemAdapter
     */
    private $filesystemAdapter;

    /**
     * CountryNamesHelper constructor.
     *
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->filesystemAdapter = new FilesystemAdapter();
    }

    /**
     * @param string $name
     *
     * @return Country|null
     *
     * @throws NonUniqueResultException
     */
    public function getDataByCountryName(string $name): ?Country
    {
        return $this->countryRepository->findOneByCountryName($name);
    }


    /**
     * @return Country[]|array
     */
    public function getCountries(): array
    {
        return $this->countryRepository->findAll();
    }
}
