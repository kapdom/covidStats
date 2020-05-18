<?php

declare(strict_types=1);

namespace App\Handler;

class ApiServiceHandler
{
    /**
     * @var iterable
     */
    private $services;

    /**
     * ApiServiceHandler constructor.
     * @param iterable $services
     */
    public function __construct(iterable $services)
    {
        $this->services = $services;
    }

    /**
     * @return iterable
     */
    public function getServices()
    {
        return $this->services;
    }
}
