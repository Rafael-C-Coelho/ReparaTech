<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class RegistrationCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }
    public function Registration(FunctionalTester $I)
    {
        $I->amOnPage('index');
        $I->see('Sign up');

        $I->click('signup');
        $I->amOnPage('signup');
        $I->see('Please fill out the following fields to signup:');

        $I->click(['link'=>'signup']);
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

        $I->fillField('SignupForm[username]', 'tester');
        $I->fillField('SignupForm[name]', 'Tester');
        $I->fillField('SignupForm[email]', 'tester@tester.test');
        $I->fillField('SignupForm[password]', 'tester');

        $I->click('signup');
        $I->seeValidationError('Password should contain at least 8 characters.');

        $I->fillField('SignupForm[password]', 'Tester@123');
        $I->click('signup');
    }

}
