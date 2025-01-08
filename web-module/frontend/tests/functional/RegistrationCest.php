<?php


namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class RegistrationCest
{
    public function Registration(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->seeLink('Sign up');
        $I->click('Sign up');
        $I->see('Please fill out the following fields to signup:');
        $I->seeInCurrentUrl('/site/signup');

        $I->seeElement('#form-signup');
        $I->click('Signup');
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Name cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

        $I->fillField('#signupform-username', 'tester');
        $I->fillField('#signupform-name', 'Tester');
        $I->fillField('#signupform-email', 'tester@tester.test');
        $I->fillField('#signupform-password', 'Te@232');

        $I->click('Signup');
        $I->seeValidationError('Password should contain at least 8 characters.');
        $I->fillField('#signupform-password', 'Tester@123');

        $I->click('Signup');
    }

}
