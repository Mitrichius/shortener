<?php

namespace App\Interfaces;

interface EncoderInterface
{
    /**
     * @param int $integer
     * @return string
     */
    public function encode(int $integer): string;

    /**
     * @param string $string
     * @return int
     */
    public function decode(string $string): int;
}
