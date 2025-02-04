<?php


namespace frontend\tests\Acceptance;

use common\models\User;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class AcceptTestCest
{
    public function saleTest(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Sign in');
        $I->click('Sign in');
        $I->see('Please fill out the following fields to login:');
        $I->fillField('LoginForm[username]', 'client');
        $I->fillField('LoginForm[password]', 'Test@123');
        $I->click('Login');
        $I->wait(3);
        $I->see('CATEGORIES');
        $I->click('CATEGORIES');
        $I->see('Seeded Tech');
        $I->click('Seeded Tech');
        $I->see('Mrs. Zoila Prohaska DVM');
        $I->click('Mrs. Zoila Prohaska DVM');
        $I->see('Add To Cart');
        $I->click('Add To Cart');
        $I->click('.fas.fa-shopping-cart.text-primary');
        $I->see('Proceed To Checkout');
        $I->click('Proceed To Checkout');
        $I->see('Shipping Details');
        $I->fillField('Address', '1234 Fake St');
        $I->fillField('Zip Code', '1111-111');
        $I->click('Submit');
    }
}
