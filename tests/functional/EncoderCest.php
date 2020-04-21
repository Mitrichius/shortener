<?php

namespace App\Tests\functional;

use App\Service\Encoder;
use App\Service\GeoService;
use App\Tests\FunctionalTester;
use Codeception\Example;

class EncoderCest
{
    private Encoder $encoder;

    public function _before(FunctionalTester $I)
    {
        $this->encoder = $I->grabService(Encoder::class);
    }

    public function encodeProvider()
    {
        return [
            [
                'decoded' => 1,
                'encoded' => '2'
            ],
            [
                'decoded' => 10,
                'encoded' => 'b'
            ],
            [
                'decoded' => 2147483648,
                'encoded' => '3bllb3'
            ],
        ];
    }

    /**
     * @dataProvider encodeProvider
     */
    public function testEncode(FunctionalTester $I, Example $dataProvider)
    {
        $encodedString = $this->encoder->encode($dataProvider['decoded']);
        $I->assertEquals($dataProvider['encoded'], $encodedString, 'Encoded string is invalid');
    }

    /**
     * @dataProvider encodeProvider
     */
    public function testDecode(FunctionalTester $I, Example $dataProvider)
    {
        $decodedString = $this->encoder->decode($dataProvider['encoded']);
        $I->assertEquals($dataProvider['decoded'], $decodedString, 'Decoded string is invalid');
    }
}
