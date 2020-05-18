<?php

namespace App\Entity;

use App\Repository\CountryCovidRepository;
use App\Traits\TCreateUpdate;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryCovidRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CountryCovid
{
    use TCreateUpdate;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
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
     * @ORM\Column(type="integer")
     */
    private $confirmed;

    /**
     * @ORM\Column(type="integer")
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     */
    private $recovered;

    /**
     * @ORM\Column(type="date")
     */
    private $dayDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hostCode;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function getConfirmed(): ?int
    {
        return $this->confirmed;
    }

    public function setConfirmed(int $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getDeaths(): int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getRecovered(): int
    {
        return $this->recovered;
    }

    public function setRecovered(int $recovered): self
    {
        $this->recovered = $recovered;

        return $this;
    }

    public function getDayDate(): \DateTimeInterface
    {
        return $this->dayDate;
    }

    public function setDayDate(\DateTimeInterface $dayDate): self
    {
        $this->dayDate = $dayDate;

        return $this;
    }

    public function getHostCode(): string
    {
        return $this->hostCode;
    }

    public function setHostCode(string $hostCode): self
    {
        $this->hostCode = $hostCode;

        return $this;
    }
}
