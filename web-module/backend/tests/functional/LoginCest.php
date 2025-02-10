<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * @param FunctionalTester $I
     */

    public function loginRepairman(FunctionalTester $I)
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

    }


    public function loginManager(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->fillField('Username', 'manager');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('manager');
        $I->amOnPage('web/index');
    }

    public function loginAdmin(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('admin');
        $I->amOnPage('web/index');
    }

    public function loginClient(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
        $I->fillField('Username', 'client');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->seeElement('body > main > div > div > div');
        $I->click('Log Out');
    }
}
