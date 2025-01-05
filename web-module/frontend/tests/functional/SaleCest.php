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
        $I->am('client');
        $I->amOnPage('product/shop?category_id=14');
        $I->see('Orlando block');
        $I->click('Orlando block');
        $I->amOnPage('product/details?id=102');
        $I->see('Orlando block');
        $I->click('Update Quantity');
        $I->click('Add to Cart');
        $I->see('Product Name');
        $I->see('Price');
        $I->see('Quantity');
        $I->see('Image');
        $I->see('Remove');
        $I->click('Proceed to Checkout');
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
