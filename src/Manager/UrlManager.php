<?php

namespace App\Manager;

use App\Entity\Url;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UrlManager
{
    /** @var string|null $url */
    private $url;
    /** @var ?int */
    private $ttl = 0;
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return self
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @param mixed $ttl
     * @return self
     */
    public function setTtl($ttl): self
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * @return Url
     * @throws \Exception
     */
    public function save(): Url
    {
        try {
            $urlEntity = new Url($this->url);
            $validTill = $this->ttl ? (new \DateTime())->modify('+ ' . $this->ttl . ' minutes') : null;
            $urlEntity ->setValidTill($validTill);
            $this->em->persist($urlEntity);
            $this->em->flush();
            return $urlEntity;
        } catch (\Exception $e) {
            $this->logger->error("Can't save url entity", [
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
