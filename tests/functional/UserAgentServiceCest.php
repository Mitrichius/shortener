<?php

namespace App\Tests\functional;

use App\Service\UserAgentService;
use App\Tests\FunctionalTester;
use Codeception\Example;

class UserAgentServiceCest
{
    private UserAgentService $uaService;

    public function uaProvider()
    {
        return [
            'chrome' => [
                'ua' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.113 Safari/537.36',
                'browser' => 'Chrome 81.0 (macOS)',
            ],
            'safari' => [
                'ua' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1 Mobile/15E148 Safari/604.1',
                'browser' => 'Safari 12.1 (iOS)',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $this->uaService = $I->grabService(UserAgentService::class);
    }

    /**
     * @dataProvider uaProvider
     */
    public function getBrowser(FunctionalTester $I, Example $dataProvider)
    {
        $I->assertEquals($dataProvider['browser'], $this->uaService->getBrowser($dataProvider['ua']));
    }

    public function getBrowserUaEmpty(FunctionalTester $I)
    {
        $I->assertNull($this->uaService->getBrowser(''));
    }

    public function getBrowserUaInvalid(FunctionalTester $I)
    {
        $I->assertNull($this->uaService->getBrowser('some random text 81'));
    }
}
