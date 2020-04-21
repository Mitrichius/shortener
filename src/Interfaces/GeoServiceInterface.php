<?php

namespace App\Interfaces;

use Psr\Log\LoggerInterface;

interface GeoServiceInterface
{
    /**
     * GeoInterface constructor.
     * @param array $config
     * @param LoggerInterface $logger
     */
    public function __construct(array $config, LoggerInterface $logger);

    /**
     * @param string $ip
     * @return string|null
     */
    public function getCountry(string $ip): ?string;

    /**
     * @param string $ip
     * @return string|null
     */
    public function getCity(string $ip): ?string;
}
