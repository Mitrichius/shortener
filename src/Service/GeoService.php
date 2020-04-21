<?php

namespace App\Service;

use App\Interfaces\GeoServiceInterface;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;
use Psr\Log\LoggerInterface;

class GeoService implements GeoServiceInterface
{
    private Reader $geo;
    private LoggerInterface $logger;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config, LoggerInterface $logger)
    {
        $this->logger = $logger;
        try {
            $this->geo = new Reader($config['geoIpDbPath'] ?? null);
        } catch (InvalidDatabaseException $e) {
            $this->logger->error("Invalid GeoIp2 DB", [
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * @param string $ip
     * @return string|null
     */
    public function getCountry(string $ip): ?string
    {
        $country = null;
        try {
            $country = $this->geo->city($ip)->country->name;
        } catch (AddressNotFoundException $e) {
            $this->logger->notice("Can't parse ip", [
                'ip' => $ip,
                'exception' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            $this->logger->error("Can't parse ip", [
                'ip' => $ip,
                'exception' => $e->getMessage(),
            ]);
        } finally {
            return $country;
        }
    }

    /**
     * @param string $ip
     * @return string|null
     */
    public function getCity(string $ip): ?string
    {
        $city = null;
        try {
            $city = $this->geo->city($ip)->city->name;
        } catch (AddressNotFoundException $e) {
            $this->logger->notice("Can't parse ip", [
                'ip' => $ip,
                'exception' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            $this->logger->error("Can't parse ip", [
                'ip' => $ip,
                'exception' => $e->getMessage(),
            ]);
        } finally {
            return $city;
        }
    }
}
