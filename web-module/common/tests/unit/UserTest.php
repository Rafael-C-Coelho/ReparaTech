<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\User;
use Yii;

class UserTest extends Unit
{
    protected function _before()
    {
        User::deleteAll();
    }

    public function testValidation()
    {
        $user = new User();

        // Test required fields
        verify($user->validate())->false();
        verify($user->errors)->arrayHasKey('username');
        verify($user->errors)->arrayHasKey('email');
        verify($user->errors)->arrayHasKey('password');
        verify($user->errors)->arrayHasKey('name');

        // Test valid user data
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password = 'Test123#@';
        $user->name = 'Test User';
        verify($user->validate())->true();

        // Test username format
        $user->username = 'test@user';
        verify($user->validate(['username']))->false();
        verify($user->errors)->arrayHasKey('username');

        // Test email format
        $user->email = 'invalid-email';
        verify($user->validate(['email']))->false();
        verify($user->errors)->arrayHasKey('email');

        // Test password format
        $user->password = 'weak';
        verify($user->validate(['password']))->false();
        verify($user->errors)->arrayHasKey('password');
    }

    public function testScenarios()
    {
        $user = new User();

        // Test client scenario
        $user->setScenario(User::SCENARIO_CLIENT);
        $user->username = 'client1';
        $user->email = 'client@example.com';
        $user->password = 'Client123#';
        $user->name = 'Client Name';
        verify($user->validate())->false();
        verify($user->errors)->arrayHasKey('nif');
        verify($user->errors)->arrayHasKey('address');
        verify($user->errors)->arrayHasKey('contact');

        $user->nif = '123456789';
        $user->address = 'Test Address';
        $user->contact = '123456789';
        verify($user->validate())->true();

        // Test repair technician scenario
        $user = new User();
        $user->setScenario(User::SCENARIO_REPAIR_TECHNICIAN);
        $user->username = 'tech1';
        $user->email = 'tech@example.com';
        $user->password = 'Tech123#';
        $user->name = 'Tech Name';
        $user->value = 'invalid';
        verify($user->validate())->false();
        verify($user->errors)->arrayHasKey('value');

        $user->value = '50';
        verify($user->validate())->true();
    }

    public function testPasswordOperations()
    {
        $user = new User();
        $plainPassword = 'Test123#@';

        $user->setPassword($plainPassword);
        verify($user->password_hash)->notEmpty();
        verify($user->validatePassword($plainPassword))->true();
        verify($user->validatePassword('wrongpassword'))->false();
    }

    public function testDeleteOperation()
    {
        $user = new User([
            'username' => 'deletetest',
            'email' => 'delete@test.com',
            'password' => 'Delete123#',
            'name' => 'Delete Test',
            'status' => User::STATUS_ACTIVE
        ]);

        $user->delete();
        verify($user->status)->equals(User::STATUS_DELETED);
        verify($user->name)->equals('Deleted User');
        verify($user->email)->stringMatchesRegExp('/@deleted\.com$/');
        verify($user->nif)->equals('');
        verify($user->address)->equals('');
    }

    public function testUserFinding()
    {
        $user = $this->createTestUser();

        $foundUser = User::find()->where(['username' => $user->username])->all();
        verify($foundUser)->notNull();
        verify($foundUser->username)->equals($user->username);

        $foundUser = User::find()->where(['id' => $user->id])->one();
        verify($foundUser)->notNull();
        verify($foundUser->id)->equals($user->id);
    }

    private function createTestUser()
    {
        $user = new User([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'name' => 'Test User',
            'status' => User::STATUS_ACTIVE
        ]);
        $user->setPassword('Test123#@');
        $user->generateAuthKey();
        $user->save();
        return $user;
    }
}