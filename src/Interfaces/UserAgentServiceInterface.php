<?php

namespace App\Interfaces;

use Psr\Log\LoggerInterface;

interface UserAgentServiceInterface
{
    /**
     * GeoInterface constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger);

    /**
     * @param string $userAgent
     * @return string|null
     */
    public function getBrowser(string $userAgent): ?string;
}
