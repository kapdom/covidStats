<?php

declare(strict_types=1);

namespace App\Model;

class CovidModel
{
    /**
     * @var string
     */
    private $hostCode;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var int
     */
    private $confirmed;

    /**
     * @var int
     */
    private $deaths;

    /**
     * @var int
     */
    private $recovered;

    /**
     * @var \DateTime
     */
    private $date;


    public function __construct(
        string $countryName,
        string $countryCode,
        int $confirmed,
        int $deaths,
        int $recovered,
        \DateTime $date,
        string $hostCode
    )
    {
        $this->countryName = $countryName;
        $this->countryCode = $countryCode;
        $this->confirmed = $confirmed;
        $this->deaths = $deaths;
        $this->recovered = $recovered;
        $this->date = $date;
        $this->hostCode = $hostCode;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return int
     */
    public function getConfirmed(): int
    {
        return $this->confirmed;
    }

    /**
     * @return int
     */
    public function getDeaths(): int
    {
        return $this->deaths;
    }

    /**
     * @return int
     */
    public function getRecovered(): int
    {
        return $this->recovered;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDataHostCode(): string
    {
        return $this->hostCode;
    }
}
