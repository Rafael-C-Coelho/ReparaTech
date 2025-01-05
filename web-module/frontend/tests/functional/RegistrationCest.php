<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class RegistrationCest
{
    public function _before(FunctionalTester $I)
    {

    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
    }
    public function Registration(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->seeLink('Sign up');
        $I->click('Sign up');
        $I->see('Please fill out the following fields to signup:');
        //$I->seeInCurrentUrl('/site/signup');

        //$I->seeElement('#form-signup');
        $I->see('Signup');
        $I->click('Signup');
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

        $I->fillField('SignupForm[username]', 'tester');
        $I->fillField('SignupForm[name]', 'Tester');
        $I->fillField('SignupForm[email]', 'tester@tester.test');
        $I->fillField('SignupForm[password]', 'tester');

        $I->click('Signup');
        $I->seeValidationError('Password should contain at least 8 characters.');

        $I->fillField('SignupForm[password]', 'Tester@123');
        $I->click('Signup');
    }

}
