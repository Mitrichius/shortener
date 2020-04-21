<?php

namespace App\Tests\functional;

use App\Service\GeoService;
use App\Tests\FunctionalTester;
use Codeception\Example;

class GeoServiceCest
{
    private GeoService $geoService;

    public function geoProvider()
    {
        return [
            'russia-moscow' => [
                'ip' => '46.242.0.219',
                'country' => 'Russia',
                'city' => 'Moscow',
            ],
            'germany-munich' => [
                'ip' => '77.47.52.76',
                'country' => 'Germany',
                'city' => 'Munich',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $this->geoService = $I->grabService(GeoService::class);
    }

    /**
     * @dataProvider geoProvider
     */
    public function getCountry(FunctionalTester $I, Example $dataProvider)
    {
        $I->assertEquals($dataProvider['country'], $this->geoService->getCountry($dataProvider['ip']));
    }

    /**
     * @dataProvider geoProvider
     */
    public function getCity(FunctionalTester $I, Example $dataProvider)
    {
        $I->assertEquals($dataProvider['city'], $this->geoService->getCity($dataProvider['ip']));
    }

    public function getCountryIpInvalid(FunctionalTester $I)
    {
        $I->assertNull($this->geoService->getCountry('127.0.0.1'));
    }

    public function getCityIpInvalid(FunctionalTester $I)
    {
        $I->assertNull($this->geoService->getCity('127.0.0.1'));
    }
}
