<?php


namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\models\ProductCategory;

class ProductCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function productCategoryTest(FunctionalTester $I)
    {
        $I->amOnRoute('login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->fillField('Username', 'manager');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('manager');
        $I->amOnPage('site/index');
        $I->click('Product Categories');
        $I->click('Create Product Category');
        $I->click('Save');
        $I->see('Name cannot be blank.');
        $I->fillField('Name', 'Mobileeee');
        $I->click('Save');
    }

    public function supplierTest(FunctionalTester $I)
    {
        $I->amOnRoute('login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->fillField('Username', 'manager');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('manager');
        $I->amOnPage('site/index');
        $I->click('Suppliers');
        $I->click('Create Supplier');
        $I->fillField('#supplier-name', 'Mobile Supplier');
        $I->fillField('#supplier-contact', '998877665');
        $I->click('Save');

    }

    public function productTest(FunctionalTester $I)
    {
        $I->amOnRoute('login');
        $I->see("Please fill out the following fields to login:");
        $I->click('Login');
        $I->fillField('Username', 'manager');
        $I->fillField('Password', 'Test@123');
        $I->click('Login');
        $I->am('manager');
        $I->amOnPage('site/index');
        $I->click('Suppliers');
        $I->click('Create Supplier');
        $I->fillField('#supplier-name', 'Mobile Supplier');
        $I->fillField('#supplier-contact', '998877665');
        $I->click('Save');
        $I->click('Product Categories');
        $I->click('Create Product Category');
        $I->click('Save');
        $I->see('Name cannot be blank.');
        $I->fillField('Name', 'Mobileeee');
        $I->click('Save');
        $I->click('Products');
        $I->click('Create Product');
        $I->click('Save');
        $I->see('Name cannot be blank.');
        $I->see('Stock cannot be blank.');
        $I->see('Supplier cannot be blank.');
        $I->see('Category Id cannot be blank.');
        $I->fillField('Name', 'Telemovel de Teste');
        $I->fillField('Price', '111');
        $I->fillField('Stock', '10');
        $I->selectOption('Supplier','Mobile Supplier');
        $I->selectOption('Category Id','Mobileeee');
        $I->seeElement('#product-image');
        $I->click('Save');

    }

}
