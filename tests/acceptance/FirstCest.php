<?php

namespace App\Tests;

use Codeception\Attribute\DataProvider;
use Codeception\Example;

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function checkHeaderTest(AcceptanceTester $I)
    {
        $I->amOnPage('/time/zone');
        $I->see('Hello TimeZoneController');
        $I->cantSee('The time zone [input-timezone] has [A] minutes offset to UTC');
        $I->cantSee('February in this year is [B] days long.');
        $I->cantSee('The specified month [C] is [D] days long.');
    }

    protected function pageProvider(): array
    {
        return [
            [
                'input_date' => "2019-07-10",
                "input_timezone" => "Europe/London",
                "timeZoneOffset" => "+60",
                "numberOfDaysInFebruary" => "28",
                "fullCurrentMonthName" => "July",
                "numDaysOfCurrentMonth" => "31",
            ],
            [
                'input_date' => "2016-11-28",
                "input_timezone" => "Asia/Tokyo",
                "timeZoneOffset" => "+540",
                "numberOfDaysInFebruary" => "29",
                "fullCurrentMonthName" => "November",
                "numDaysOfCurrentMonth" => "30",
            ],
            [
                'input_date' => "1853-01-30",
                "input_timezone" => "America/Lower_Princes",
                "timeZoneOffset" => "-240",
                "numberOfDaysInFebruary" => "28",
                "fullCurrentMonthName" => "January",
                "numDaysOfCurrentMonth" => "31",
            ]
        ];
    }

    /**
     * @dataProvider pageProvider
     */
    public function checkTimeZoneTextTest(AcceptanceTester $I, Example $example)
    {
        $I->amOnPage('/time/zone');
        $I->submitForm('#timezone_form', array(
                'form' => array(
                    'date' => $example['input_date'],
                    'timezone' => $example['input_timezone'],
                )
            )
        );

        $I->see('The time zone '.$example['input_timezone']);
        $I->see('has '.$example['timeZoneOffset'].' minutes offset to UTC');
        $I->see('February in this year is '.$example['numberOfDaysInFebruary'].' days long.');
        $I->see('The specified month '.$example['fullCurrentMonthName'].' is '.$example['numDaysOfCurrentMonth'].' days long.');
    }
}
