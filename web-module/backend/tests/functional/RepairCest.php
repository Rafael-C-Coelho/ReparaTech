<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class RepairCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }

    public function Repair(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->fillField('Username', 'repairman');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('admin');
        $I->amOnPage('web/index');
        $I->click('Repairs');
        $I->see('Repairs');
        $I->click('Create Repair');
        $I->click('Save');
        $I->see('Device cannot be blank.');
        $I->see('Description cannot be blank.');
        $I->fillField('Hours Spent Working', '2');
        $I->fillField('Device', 'Samsung Galaxy S10');
        $I->checkOption('Created');
        $I->fillField('Description', 'Broken Screen');
        $I->chooseOption('Client');
        $I->click('Save');
    }
}
