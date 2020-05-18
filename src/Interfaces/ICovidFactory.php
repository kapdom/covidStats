<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ICovidFactory
{
    public function creatCovidFromArray(& $data, string $HostCode): array ;
}
