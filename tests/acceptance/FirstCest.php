<?php
namespace App\Tests;
use App\Tests\AcceptanceTester;
class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/time/zone');
        $I->see('Hello TimeZoneController');
    }
}
