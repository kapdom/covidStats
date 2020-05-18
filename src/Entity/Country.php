<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $iso2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $continent;

    /**
     * @ORM\Column(type="integer")
     */
    private $population;

    /**
     * @ORM\Column(type="json")
     */
    private $coordinate = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $flagUrl;


    /**
     * Country constructor.
     * @param string $name
     * @param string $iso2Code
     * @param string $continent
     * @param int $population
     * @param array $coordinate
     * @param string $flagUrl
     */
    public function __construct(
        string $name,
        string $iso2Code,
        string $continent,
        int $population,
        array $coordinate,
        string $flagUrl
    )
    {
        $this->name = $name;
        $this->iso2 = $iso2Code;
        $this->continent = $continent;
        $this->population = $population;
        $this->coordinate = $coordinate;
        $this->flagUrl = $flagUrl;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    public function setIso2(string $iso2): self
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getCoordinate(): ?array
    {
        return $this->coordinate;
    }

    public function setCoordinate(array $coordinate): self
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    public function getFlagUrl(): ?string
    {
        return $this->flagUrl;
    }

    public function setFlagUrl(string $flag_url): self
    {
        $this->flagUrl = $flag_url;

        return $this;
    }
}
