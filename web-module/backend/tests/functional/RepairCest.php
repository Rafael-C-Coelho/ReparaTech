<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class RepairCest
{
    public function Repair(FunctionalTester $I)
    {
        $I->amOnRoute('login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->fillField('Username', 'repairman');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('repairman');
        $I->amOnPage('site/index');
        $I->click('Repairs');
        $I->click('Create Repair');
        $I->click('button.btn-success');
        $I->see('Device cannot be blank.');
        $I->see('Description cannot be blank.');
        $I->fillField('Hours Spent Working', '2');
        $I->selectOption('Device','Computer');
        $I->selectOption('Progress','Created');
        $I->fillField('Description', 'Broken Screen');
        $I->selectOption('Client ID','Client');
        $I->click('Save');
    }
}
