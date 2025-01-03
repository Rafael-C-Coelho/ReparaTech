<?php

namespace common\tests\Unit;

use common\models\User;
use common\tests\UnitTester;
use Yii;

class UserModelTest extends \Codeception\Test\Unit
{
    private const VALID_USERNAME = 'testuser123';
    private const VALID_EMAIL = 'test@example.com';
    private const VALID_PASSWORD = 'Test123@pass';
    private const VALID_NAME = 'Test User';
    private const VALID_NIF = '123456789';
    private const VALID_ADDRESS = 'Test Address 123';
    private const VALID_CONTACT = '123456789';
    private const VALID_VALUE = '50.00';

    protected UnitTester $tester;
    private $user;

    protected function _before()
    {
        User::deleteAll();
    }

    public function testRequiredFieldValidation()
    {
        $user = new User();
        $this->assertFalse($user->validate());

        $expectedErrors = ['username', 'email', 'password', 'name'];
        foreach ($expectedErrors as $attribute) {
            $this->assertTrue($user->hasErrors($attribute));
        }
    }

    public function testClientScenarioValidation()
    {
        $user = $this->createValidUser();
        $user->setScenarioBasedOnRole('client');

        $user->nif = null;
        $user->address = null;
        $user->contact = null;

        $this->assertFalse($user->validate());
        $this->assertTrue($user->hasErrors('nif'));
        $this->assertTrue($user->hasErrors('address'));
        $this->assertTrue($user->hasErrors('contact'));
    }

    public function testManagerScenarioValidation()
    {
        $user = $this->createValidUser();
        $user->setScenarioBasedOnRole('manager');

        $this->assertTrue($user->validate());
    }

    public function testRepairTechnicianScenarioValidation()
    {
        $user = $this->createValidUser();
        $user->setScenarioBasedOnRole('repairTechnician');

        $user->value = null;
        $this->assertFalse($user->validate());

        $user->value = self::VALID_VALUE;
        $this->assertTrue($user->validate());
    }

    public function testPasswordValidation()
    {
        $user = $this->createValidUser();

        $invalidPasswords = ['short', 'NoSpecialChar1', 'nodigit@char', 'nocaps1@char'];
        foreach ($invalidPasswords as $password) {
            $user->password = $password;
            $user->setPassword($password);
            $this->assertFalse($user->validate(['password']));
        }

        $user->password = self::VALID_PASSWORD;
        $user->setPassword(self::VALID_PASSWORD);
        $this->assertTrue($user->validate(['password']));
    }

    public function testUsernameValidation()
    {
        $user = $this->createValidUser();

        $invalidUsernames = ['a', 'user@name', 'very_long_username_exceeds_twenty'];
        foreach ($invalidUsernames as $username) {
            $user->username = $username;
            $this->assertFalse($user->validate(['username']));
        }

        $user->username = self::VALID_USERNAME;
        $this->assertTrue($user->validate(['username']));
    }

    public function testNIFValidation()
    {
        $user = $this->createValidUser();
        $user->setScenarioBasedOnRole('client');

        $invalidNIFs = ['12345', '1234567890', 'abc123456'];
        foreach ($invalidNIFs as $nif) {
            $user->nif = $nif;
            $this->assertFalse($user->validate(['nif']));
        }

        $user->nif = self::VALID_NIF;
        $this->assertTrue($user->validate(['nif']));
    }

    public function testRepairTechnicianScenario()
    {
        $user = $this->createValidUser();
        $user->setScenarioBasedOnRole('repairTechnician');

        $user->value = 'not_a_number';
        $this->assertFalse($user->validate(['value']));

        $user->value = self::VALID_VALUE;
        $this->assertTrue($user->validate(['value']));
    }

    public function testPasswordHashGeneration()
    {
        $user = $this->createValidUser();
        $user->setPassword(self::VALID_PASSWORD);

        $this->assertNotNull($user->password_hash);
        $this->assertTrue(Yii::$app->security->validatePassword(self::VALID_PASSWORD, $user->password_hash));
    }

    public function testUserDeletion()
    {
        $user = $this->createValidUser();
        $user->delete();

        $deletedUser = User::findOne($user->id);
        $this->assertEquals(User::STATUS_DELETED, $deletedUser->status);
        $this->assertEquals('Deleted User', $deletedUser->name);
        $this->assertMatchesRegularExpression('/^\d{10}@deleted\.com$/', $deletedUser->email);
        $this->assertMatchesRegularExpression('/^\d{10}$/', $deletedUser->username);
        $this->assertEmpty($deletedUser->nif);
        $this->assertEmpty($deletedUser->address);
    }

    public function testUniqueEmailAndUsername()
    {
        $user1 = $this->createValidUser();
        $user1->save();

        $user2 = $this->createValidUser();
        $this->assertFalse($user2->validate(['username', 'email']));
    }

    private function createValidUser()
    {
        $user = new User();
        $user->username = self::VALID_USERNAME;
        $user->email = self::VALID_EMAIL;
        $user->password = self::VALID_PASSWORD;
        $user->setPassword(self::VALID_PASSWORD);
        $user->name = self::VALID_NAME;
        $user->nif = self::VALID_NIF;
        $user->address = self::VALID_ADDRESS;
        $user->contact = self::VALID_CONTACT;
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->save();
        return $user;
    }
}