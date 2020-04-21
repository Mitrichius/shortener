<?php

namespace App\Service;

use App\Entity\Stat;
use App\Entity\Url;
use App\Interfaces\GeoServiceInterface;
use App\Interfaces\UserAgentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use GeoIp2\Database\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class StatService
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;
    private GeoServiceInterface $geoService;
    private UserAgentServiceInterface $uaService;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,
        GeoServiceInterface $geoService,
        UserAgentServiceInterface $uaService
    ) {
        $this->em             = $em;
        $this->logger         = $logger;
        $this->geoService     = $geoService;
        $this->uaService      = $uaService;
    }

    /**
     * @param Request $request
     * @param Url $urlEntity
     * @return Stat
     */
    public function save(Request $request, Url $urlEntity): Stat
    {
        $ip = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');
        $stat      = new Stat();
        $stat
            ->setUrl($urlEntity)
            ->setCreatedAt(new \DateTime())
            ->setIp($ip)
            ->setUa($userAgent)
            ->setCity($this->geoService->getCity($ip))
            ->setCountry($this->geoService->getCountry($ip))
            ->setBrowser($this->uaService->getBrowser($userAgent));
        $this->em->persist($stat);
        $this->em->flush();
        return $stat;
    }
}
