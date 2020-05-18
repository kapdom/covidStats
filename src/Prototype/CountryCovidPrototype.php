<?php

declare(strict_types=1);

namespace App\Prototype;

use App\Entity\CountryCovid;

class CountryCovidPrototype
{
    /**
     * @var CountryCovid
     */
    protected $object;

    public function __construct(CountryCovid $countryCovid)
    {
        $this->object = $countryCovid;
    }

    public function setName(string $name)
    {
        $this->object->setName($name);

        return $this;
    }

    public function setIso2(string $iso2Code)
    {
        $this->object->setIso2($iso2Code);

        return $this;
    }

    public function setConfirmed(int $confirmed)
    {
        $this->object->setConfirmed($confirmed);

        return $this;
    }

    public function setDeaths(int $deaths)
    {
        $this->object->setDeaths($deaths);

        return $this;
    }

    public function setRecovered(int $recovered)
    {
        $this->object->setRecovered($recovered);

        return $this;
    }

    public function setDayDate(\DateTimeInterface $dateTime)
    {
        $this->object->setDayDate($dateTime);

        return $this;
    }

    public function setHostCode(string $hostCode)
    {
        $this->object->setHostCode($hostCode);

        return $this;
    }

    public function getClonedObject()
    {
        return clone $this->object;

    }
}
