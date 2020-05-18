<?php

declare(strict_types=1);

namespace App\Factory;

use App\Provider\CountryNamesProvider;
use App\Interfaces\ICovidFactory;

abstract class AbstractCountryCovidFactory implements ICovidFactory
{
    /**
     * @var CountryNamesProvider
     */
    protected $countryNamesProvider;

    /**
     * CoronaImahoMapper constructor.
     *
     * @param CountryNamesProvider $countryNamesProvider
     */
    public function __construct(CountryNamesProvider $countryNamesProvider)
    {
        $this->countryNamesProvider = $countryNamesProvider;
    }
}
