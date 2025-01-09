<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SaleCest
{
    public function _before(FunctionalTester $I)
    {

    }

    public function createSale(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->see('Please fill out the following fields to login:');
        $I->click('Login');
        $I->seeValidationError("Username cannot be blank.");
        $I->seeValidationError("Password cannot be blank.");
        $I->fillField('Username', 'client');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        //$I->amOnPage('site/painelClient');
        $I->am('client');
        $I->see('CATEGORIES');
        $I->click('CATEGORIES');
        $I->see('Seeded Tech');
        $I->click('Seeded Tech');
        $I->amOnPage('shop');
        $I->see("All categories");
        $I->seeElement('h5.card-title');
        $I->click(['css' => 'h5.card-title']);
        $I->click('button.btn.btn-primary');
        $I->seeElement('button.btn.btn-primary');
        $I->click('button.btn.btn-primary');


        $I->click('i.fas.fa-shopping-cart.text-primary');
        $I->amOnPage('cart');
        $I->see('Subtotal');
        $I->see('Shipping', );
        $I->see('Total');
        $I->see('Product name ');
        $I->see('Price');
        $I->see('Quantity');
        $I->see('Image');
        $I->see('Remove');
        $I->click('button.btn-primary');
        $I->see('Shipping Details');
        $I->fillField('Address', 'Rua 1');
        $I->fillField('Zip Code', '2000-000');
        $I->click('Submit');
        $I->amOnPage('painelClient');

    }
}
