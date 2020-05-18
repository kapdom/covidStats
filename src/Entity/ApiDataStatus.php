<?php

namespace App\Entity;

use App\Repository\ApiDataStatusRepository;
use App\Traits\TCreateUpdate;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiDataStatusRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class ApiDataStatus
{
    public const STATUS_DONE = 'DONE';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_FAIL = 'FAIL';

    public const DATA_TYPE_ALL = 'ALL';
    public const DATA_TYPE_SINGLE = 'SINGLE';

    use TCreateUpdate;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hostName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dataType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHostName(): ?string
    {
        return $this->hostName;
    }

    public function setHostName(string $hostName): self
    {
        $this->hostName = $hostName;

        return $this;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): self
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
