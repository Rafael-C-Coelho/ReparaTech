<?php

namespace common\tests\Unit;

use common\models\Budget;
use common\models\Repair;
use common\models\User;
use common\tests\UnitTester;
use Yii;

class BudgetTest extends \Codeception\Test\Unit
{
    private const VALID_VALUE = 100.50;
    private const VALID_DATE = '2024-02-05'; // Future date
    private const VALID_TIME = '14:30:00';
    private const VALID_DESCRIPTION = 'Test repair description for the budget';
    private const VALID_HOURS = 2.5;

    protected UnitTester $tester;
    private $budget;
    private $repairman;
    private $client;
    private $repair;

    protected function _before()
    {
        Budget::deleteAll();
        Repair::deleteAll();
        User::deleteAll();

        // Create test repair technician
        $this->repairman = new User();
        $this->repairman->setScenarioBasedOnRole('repairTechnician');
        $this->repairman->email = 'repairman@test.test';
        $this->repairman->username = 'repairman';
        $this->repairman->password = 'Test123@pass';
        $this->repairman->setPassword('Test123@pass');
        $this->repairman->generateAuthKey();
        $this->repairman->name = 'Repair Technician';
        $this->repairman->value = '21.90';
        $this->repairman->status = User::STATUS_ACTIVE;
        $this->repairman->save();

        $this->client = new User();
        $this->client->setScenarioBasedOnRole('client');
        $this->client->email = 'client@test.test';
        $this->client->username = 'client';
        $this->client->password = 'Test123@pass';
        $this->client->setPassword('Test123@pass');
        $this->client->generateAuthKey();
        $this->client->name = 'Client';
        $this->client->status = User::STATUS_ACTIVE;
        $this->client->nif = '123456789';
        $this->client->address = 'Test Address 123';
        $this->client->contact = '123456789';
        $this->client->save();

        // Create test repair
        $this->repair = new Repair();
        $this->repair->description = 'Test repair description';
        $this->repair->device = Repair::DEVICE_PHONE;
        $this->repair->progress = Repair::STATUS_CREATED;
        $this->repair->client_id = $this->client->id;
        $this->repair->repairman_id = $this->repairman->id;
        $this->repair->save();

        $this->budget = $this->createValidBudget();
        $this->budget->save();
    }

    // Required Fields Tests
    public function testRequiredFields()
    {
        $budget = new Budget();
        $this->assertFalse($budget->validate());

        $requiredFields = [
            'value', 'date', 'time', 'description', 'repair_id', 'status', 'hours_estimated_working',
        ];

        foreach ($requiredFields as $field) {
            $this->assertTrue(isset($budget->errors[$field]));
        }
    }

    // Value Validation Tests
    public function testValueValidation()
    {
        $invalidValues = [
            0 => 'Value must be at least 0.01',
            -1 => 'Value must be at least 0.01',
            1000000 => 'Value cannot exceed 999,999.99',
            'abc' => 'Value must be between 0.01 and 999,999.99'
        ];

        foreach ($invalidValues as $value => $expectedError) {
            $this->budget->value = $value;
            $this->assertFalse($this->budget->validate(['value']));
            $this->assertContains($expectedError, $this->budget->getErrors('value'));
        }

        $validValues = [0.01, 1, 999999.99, 500.50];
        foreach ($validValues as $value) {
            $this->budget->value = $value;
            $this->assertTrue($this->budget->validate(['value']));
        }
    }

    // Hours Validation Tests
    public function testHoursValidation()
    {
        $invalidHours = [
            0 => 'Hours must be at least 30 minutes (0.5)',
            169 => 'Hours cannot exceed one week (168 hours)',
            -1 => 'Hours must be at least 30 minutes (0.5)',
            'abc' => 'Hours must be between 0.5 and 168'
        ];

        foreach ($invalidHours as $hours => $expectedError) {
            $this->budget->hours_estimated_working = $hours;
            $this->assertFalse($this->budget->validate(['hours_estimated_working']));
            $this->assertContains($expectedError, $this->budget->getErrors('hours_estimated_working'));
        }

        $validHours = [0.5, 1, 168, 40];
        foreach ($validHours as $hours) {
            $this->budget->hours_estimated_working = $hours;
            $this->assertTrue($this->budget->validate(['hours_estimated_working']));
        }
    }

    // Description Validation Tests
    public function testDescriptionValidation()
    {
        $this->budget->description = 'Too short';
        $this->assertFalse($this->budget->validate(['description']));
        $this->assertContains('Description must be at least 10 characters', $this->budget->getErrors('description'));

        $this->budget->description = str_repeat('a', 1001);
        $this->assertFalse($this->budget->validate(['description']));
        $this->assertContains('Description cannot exceed 1000 characters', $this->budget->getErrors('description'));

        // Test HTML stripping
        $this->budget->description = '<script>alert("test")</script>Valid description';
        $this->budget->validate();
        $this->assertEquals('alert("test")Valid description', $this->budget->description);
    }

    // Status Validation Tests
    public function testStatusValidation()
    {
        $this->budget->status = 'InvalidStatus';
        $this->assertFalse($this->budget->validate(['status']));
        $this->assertContains('Invalid status value', $this->budget->getErrors('status'));

        $validStatuses = [
            Budget::STATUS_PENDING,
            Budget::STATUS_APPROVED,
            Budget::STATUS_REJECTED
        ];

        foreach ($validStatuses as $status) {
            $this->budget->status = $status;
            $this->assertTrue($this->budget->validate(['status']));
        }
    }

    // Date and Time Validation Tests
    public function testDateTimeValidation()
    {
        // Test past date
        $this->budget->date = '2020-01-01';
        $this->assertTrue($this->budget->validate(['date']));

        // Test invalid date format
        $this->budget->date = 'invalid-date';
        $this->assertFalse($this->budget->validate(['date']));

        // Test invalid time format
        $this->budget->time = '25:00:00';
        $this->assertFalse($this->budget->validate(['time']));
    }

    // Foreign Key Validation Tests
    public function testForeignKeyValidation()
    {
        $this->budget->repair_id = 999999;
        $this->assertFalse($this->budget->validate(['repair_id']));

        $this->budget->repairman_id = 999999;
        $this->assertFalse($this->budget->validate(['repairman_id']));
    }

    // Repairman Role Validation Test
    public function testRepairmanRoleValidation()
    {
        $this->budget->repairman_id = 999;
        $this->assertFalse($this->budget->validate(['repairman_id']));
    }

    // CRUD Operation Tests
    public function testCreateBudget()
    {
        $this->budget = $this->createValidBudget();
        $this->budget->validate();
        $this->assertTrue($this->budget->save());
        $savedBudget = Budget::findOne($this->budget->id);
        $this->assertNotNull($savedBudget);
        $this->assertEquals(self::VALID_VALUE, $savedBudget->value);
    }

    public function testReadBudget()
    {
        $this->budget = $this->createValidBudget();
        $this->budget->save();
        $foundBudget = Budget::findOne($this->budget->id);

        $this->assertNotNull($foundBudget);
        $this->assertEquals(self::VALID_DESCRIPTION, $foundBudget->description);
        $this->assertEquals(self::VALID_VALUE, $foundBudget->value);
    }

    public function testUpdateBudget()
    {
        $this->budget = $this->createValidBudget();
        $this->budget->save();
        $this->budget->validate();

        $newValue = 200.00;
        $this->budget->value = $newValue;
        $this->budget->save();

        $updatedBudget = Budget::findOne($this->budget->id);
        $this->assertEquals($newValue, $updatedBudget->value);
    }

    public function testDeleteBudget()
    {
        $this->budget = $this->createValidBudget();
        $this->budget->save();
        $budgetId = $this->budget->id;

        $this->budget->delete();

        $deletedBudget = Budget::findOne($budgetId);
        $this->assertNull($deletedBudget);
    }

    private function createValidBudget()
    {
        $budget = new Budget();
        $budget->value = self::VALID_VALUE;
        $budget->date = self::VALID_DATE;
        $budget->time = self::VALID_TIME;
        $budget->description = self::VALID_DESCRIPTION;
        $budget->repair_id = $this->repair->id;
        $budget->repairman_id = $this->repairman->id;
        $budget->status = Budget::STATUS_PENDING;
        $budget->hours_estimated_working = self::VALID_HOURS;
        return $budget;
    }
}