<?php

namespace App\Service;

use App\Entity\Url;
use App\Interfaces\EncoderInterface;
use App\Repository\UrlRepository;

class UrlService
{
    private EncoderInterface $encoder;
    private UrlRepository $urlRepository;

    public function __construct(EncoderInterface $encoder, UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->encoder       = $encoder;
    }

    /**
     * @param Url $urlEntity
     * @return string
     */
    public function shorten(Url $urlEntity)
    {
        return $this->encoder->encode($urlEntity->getId());
    }

    /**
     * @param string $shortLink
     */
    public function enlarge(string $shortLink)
    {
        $id = $this->encoder->decode($shortLink);
        return $this->urlRepository->find($id);
    }
}
