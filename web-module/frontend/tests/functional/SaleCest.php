<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class SaleCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('product/shop?category_id=14');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
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
        $I->amOnPage('product/shop');
        $I->see('Selina Moen II');
        $I->click('Selina Moen II');
        //$I->amOnPage('product/details?id=1');
        $I->see('Selina Moen II');
        //$I->click('Update Quantity');
        //$I->see('+');
        //$I->click('+');
        //$I->see('-');
        //$I->click('-');
        $I->click('Add To Cart');
        $I->click('Cart');
        $I->amOnPage('site/cart');
        //$I->see('Subtotal');
        //$I->see('Shipping', );
        //$I->see('Total');
        //$I->see('Product name ');
        //$I->see('Price');
        //$I->see('Quantity');
        //$I->see('Image');
        //$I->see('Remove');
        $I->click( 'Proceed to Checkout');
        $I->see('Shipping Details');
        $I->seeValidationError('Preencha este campo');
        $I->fillField('Address', 'Rua 1');
        $I->seeValidationError('Preencha este campo');
        $I->fillField('Zip Code', '2000-000');
        $I->click('Submit');
        $I->see('Purchase completed successfully.');
        $I->amOnPage('site/painelClient');

    }
}
