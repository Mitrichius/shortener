<?php

namespace App\Service;

use App\Interfaces\EncoderInterface;

class Encoder implements EncoderInterface
{
    private const ALPHABET = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
    private const ALPHABET_LENGTH = 63;

    /**
     * {@inheritdoc}
     */
    public function encode(int $integer): string
    {
        $result = '';
        while ($integer > 0) {
            $result = self::ALPHABET[($integer % self::ALPHABET_LENGTH)] . $result;
            $integer = (int) ($integer / self::ALPHABET_LENGTH);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function decode(string $string): int
    {
        $result = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            $result = $result * self::ALPHABET_LENGTH + strpos(self::ALPHABET, $string[$i]);
        }
        return (int) $result;
    }
}
