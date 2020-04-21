<?php

namespace App\Service;

use App\Interfaces\UserAgentServiceInterface;
use Psr\Log\LoggerInterface;

class UserAgentService implements UserAgentServiceInterface
{
    private LoggerInterface $logger;

    /**
     * GeoInterface constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $userAgent
     * @return string|null
     */
    public function getBrowser(string $userAgent): ?string
    {
        $browser = get_browser($userAgent);
        if ($browser) {
            $browserFull = sprintf(
                '%s %s (%s)',
                $browser->browser,
                $browser->version,
                $browser->platform,
            );
            return $browserFull === 'Default Browser 0.0 (unknown)' ? null : $browserFull;
        }
        return null;
    }
}
