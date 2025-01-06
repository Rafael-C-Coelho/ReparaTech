<?php

namespace common\tests\unit\models;

use common\models\Booking;
use common\models\Repair;
use Codeception\Test\Unit;
use common\fixtures\BookingFixture;
use common\fixtures\RepairFixture;
use common\models\User;

class BookingTest extends Unit
{
    const VALID_DATE = '2026-01-10';
    const VALID_TIME = '14:00';
    const VALID_STATUS = Booking::STATUS_REQUESTED;

    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    protected $client;
    protected $repairman;
    protected $repair1;
    protected $repair2;
    protected $booking1;
    protected $booking2;

    protected function _before()
    {
        Booking::deleteAll();
        Repair::deleteAll();
        User::deleteAll();

        $this->client = new User();
        $this->client->username = 'testuser';
        $this->client->setScenarioBasedOnRole('client');
        $this->client->setPassword('Test123@pass');
        $this->client->password = 'Test123@pass';
        $this->client->name = 'Test User';
        $this->client->email = 'test@test.test';
        $this->client->nif = '123456789';
        $this->client->address = 'Test Address 123';
        $this->client->contact = '123456789';
        $this->client->status = User::STATUS_ACTIVE;
        $this->client->generateAuthKey();
        $this->client->save();

        $this->repairman = new User();
        $this->repairman->username = 'testrepairman';
        $this->repairman->setScenarioBasedOnRole('repairTechnician');
        $this->repairman->setPassword('Test123@pass');
        $this->repairman->password = 'Test123@pass';
        $this->repairman->name = 'Test User';
        $this->repairman->email = 'repairman@test.test';
        $this->repairman->value = '12.89';
        $this->repairman->status = User::STATUS_ACTIVE;
        $this->repairman->generateAuthKey();
        $this->repairman->save();

        $this->repair1 = new Repair([
            'client_id' => $this->client->id,
            'device' => Repair::DEVICE_PHONE,
            'description' => 'Test repair description',
            'progress' => Repair::STATUS_CREATED,
            'repairman_id' => $this->repairman->id,
        ]);
        $this->repair1->save();

        $this->repair2 = new Repair([
            'client_id' => $this->client->id,
            'device' => Repair::DEVICE_PHONE,
            'description' => 'Test repair description',
            'progress' => Repair::STATUS_CREATED,
            'repairman_id' => $this->repairman->id,
        ]);
        $this->repair2->save();

        $this->booking1 = new Booking([
            'date' => '2026-01-10',
            'time' => '10:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_CONFIRMED
        ]);
        $this->booking1->save();
        $this->booking2 = new Booking([
            'date' => '2026-01-10',
            'time' => '12:00',
            'repair_id' => $this->repair2->id,
            'status' => Booking::STATUS_REQUESTED
        ]);
        $this->booking2->save();

    }

    public function testValidateEmptyFields()
    {
        $model = new Booking();

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('date', $model->errors);
        $this->assertArrayHasKey('time', $model->errors);
        $this->assertArrayHasKey('repair_id', $model->errors);
        $this->assertArrayHasKey('status', $model->errors);
    }

    public function testValidateDateFormat()
    {
        $model = new Booking([
            'date' => 'invalid-date',
            'time' => '14:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('date', $model->errors);
    }

    public function testValidateTimeFormat()
    {
        $model = new Booking([
            'date' => '2025-01-10',
            'time' => 'invalid-time',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('time', $model->errors);
    }

    public function testValidatePastDate()
    {
        $model = new Booking([
            'date' => '2020-01-01',
            'time' => '14:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('date', $model->errors);
        $this->assertContains('Booking date must be in the future.', $model->errors['date']);
    }

    public function testValidateWorkingHours()
    {
        // Test before working hours
        $model = new Booking([
            'date' => '2025-01-10',
            'time' => '08:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('time', $model->errors);

        // Test after working hours
        $model->time = '18:01';
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('time', $model->errors);

        // Test valid working hours
        $model->time = '14:00';
        $model->validate();
        $this->assertArrayNotHasKey('time', $model->errors);
    }

    public function testValidateStatus()
    {
        $model = new Booking([
            'date' => '2025-01-10',
            'time' => '14:00',
            'repair_id' => $this->repair1->id,
            'status' => 'invalid-status'
        ]);

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('status', $model->errors);

        // Test all valid statuses
        foreach ([
                     Booking::STATUS_REQUESTED,
                     Booking::STATUS_CONFIRMED,
                     Booking::STATUS_CANCELLED,
                     Booking::STATUS_DENIED
                 ] as $status) {
            $model->status = $status;
            $model->validate();
            $this->assertArrayNotHasKey('status', $model->errors);
        }
    }

    public function testValidRepairRelation()
    {
        $model = new Booking([
            'date' => '2025-01-10',
            'time' => '14:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);
        $model->validate();
        $this->assertTrue($model->validate());

        // Test with non-existent repair_id
        $model->repair_id = 99999;
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('repair_id', $model->errors);
    }

    public function testSuccessfulBooking()
    {
        $model = new Booking([
            'date' => '2026-01-10',
            'time' => '14:00',
            'repair_id' => $this->repair1->id,
            'status' => Booking::STATUS_REQUESTED
        ]);

        $model->validate();
        $this->assertTrue($model->validate());
        $this->assertTrue($model->save());
    }

    private function createValidBooking()
    {
        $booking = new Booking();
        $booking->date = self::VALID_DATE;
        $booking->time = self::VALID_TIME;
        $booking->repair_id = $this->repair1->id;
        $booking->status = self::VALID_STATUS;
        return $booking;
    }

    public function testCreateBooking()
    {
        $booking = $this->createValidBooking();
        $booking->validate();
        $this->assertTrue($booking->save());

        // Verify the booking was saved
        $savedBooking = Booking::findOne($booking->id);
        $this->assertNotNull($savedBooking);
        $this->assertEquals(self::VALID_DATE, $savedBooking->date);
        $this->assertEquals(self::VALID_TIME . ':00', $savedBooking->time);
        $this->assertEquals(self::VALID_STATUS, $savedBooking->status);
    }

    public function testCreateInvalidBooking()
    {
        $booking = new Booking();
        $this->assertFalse($booking->save());

        // Verify error messages for required fields
        $this->assertTrue($booking->hasErrors('date'));
        $this->assertTrue($booking->hasErrors('time'));
        $this->assertTrue($booking->hasErrors('repair_id'));
        $this->assertTrue($booking->hasErrors('status'));
    }

    // READ tests
    public function testReadBooking()
    {
        $booking = $this->createValidBooking();
        $booking->save();
        $booking->validate();

        // Test findOne
        $foundBooking = Booking::findOne($booking->id);
        $this->assertNotNull($foundBooking);
        $this->assertEquals($booking->date, $foundBooking->date);
        $this->assertEquals($booking->time . ':00', $foundBooking->time);
        $this->assertEquals($booking->status, $foundBooking->status);
    }

    public function testReadNonExistentBooking()
    {
        $nonExistentBooking = Booking::findOne(999999);
        $this->assertNull($nonExistentBooking);
    }

    // UPDATE tests
    public function testUpdateBooking()
    {
        $booking = $this->createValidBooking();
        $booking->save();

        // Update booking
        $newDate = '2025-01-15';
        $newTime = '15:00';
        $newStatus = Booking::STATUS_CONFIRMED;

        $booking->date = $newDate;
        $booking->time = $newTime;
        $booking->status = $newStatus;
        $booking->validate();

        $this->assertTrue($booking->save());

        // Verify updates
        $updatedBooking = Booking::findOne($booking->id);
        $this->assertEquals($newDate, $updatedBooking->date);
        $this->assertEquals($newTime . ':00', $updatedBooking->time);
        $this->assertEquals($newStatus, $updatedBooking->status);
    }

    public function testUpdateWithInvalidData()
    {
        $booking = $this->createValidBooking();
        $booking->save();

        // Try to update with invalid data
        $booking->date = 'invalid-date';
        $booking->time = 'invalid-time';
        $booking->status = 'invalid-status';

        $this->assertFalse($booking->save());
        $this->assertTrue($booking->hasErrors('date'));
        $this->assertTrue($booking->hasErrors('time'));
        $this->assertTrue($booking->hasErrors('status'));
    }

    // DELETE tests
    public function testDeleteBooking()
    {
        $booking = $this->createValidBooking();
        $booking->save();
        $booking->validate();

        $bookingId = $booking->id;
        $this->assertTrue($booking->delete() > 0);

        // Verify deletion
        $deletedBooking = Booking::findOne($bookingId);
        $this->assertNull($deletedBooking);
    }

    public function testDeleteNonExistentBooking()
    {
        $booking = new Booking();
        $booking->id = 999999;
        $this->assertEquals(0, $booking->delete());
    }
}