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
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */

    public function loginRepairman(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->seevalidationError('Username cannot be blank.');
        $I->seevalidationError('Password cannot be blank.');
        $I->fillField('Username', 'repairman');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('repairman');
        $I->amOnPage('web/index');

    }

    public function loginManager(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->seevalidationError('Username cannot be blank.');
        $I->seevalidationError('Password cannot be blank.');
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
        $I->seevalidationError('Username cannot be blank.');
        $I->seevalidationError('Password cannot be blank.');
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
        $I->seevalidationError('Username cannot be blank.');
        $I->seevalidationError('Password cannot be blank.');
        $I->fillField('Username', 'client');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->see('You are not allowed to perform this action.');
        $I->click('Log Out');
    }
}
