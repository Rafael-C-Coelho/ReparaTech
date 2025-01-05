<?php

namespace common\models;

use common\models\Repair;
use yii\db\ActiveRecord;

class Booking extends ActiveRecord
{
    // Define status constants
    const STATUS_REQUESTED = 'Requested';
    const STATUS_CONFIRMED = 'Confirmed';
    const STATUS_DENIED = 'Denied';
    const STATUS_CANCELLED = 'Cancelled';

    public static function tableName()
    {
        return '{{%bookings}}';
    }

    public function rules()
    {
        return [
            // Required fields
            [['date', 'time', 'repair_id', 'status'], 'required'],

            // Data type rules
            [['repair_id'], 'integer'],
            [['status'], 'string'],

            // Date and time validation
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['time', 'time', 'format' => 'php:H:i'],
            ['date', 'validateFutureDate'],

            // Working hours validation (assuming 9 AM to 5 PM)
            ['time', 'validateWorkingHours'],

            // Status validation
            ['status', 'in', 'range' => [
                self::STATUS_REQUESTED,
                self::STATUS_CONFIRMED,
                self::STATUS_CANCELLED,
                self::STATUS_DENIED
            ]],

            // Foreign key validation
            [['repair_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Repair::class,
                'targetAttribute' => ['repair_id' => 'id']
            ],
        ];
    }

    /**
     * Validates that the booking date is in the future
     */
    public function validateFutureDate($attribute, $params)
    {
        if (strtotime($this->date) < strtotime(date('Y-m-d'))) {
            $this->addError($attribute, 'Booking date must be in the future.');
        }
    }

    /**
     * Validates that the booking time is within working hours
     */
    public function validateWorkingHours($attribute, $params)
    {
        $time = strtotime($this->time);
        $startTime = strtotime('09:00');
        $endTime = strtotime('18:00');

        if ($time < $startTime || $time > $endTime) {
            $this->addError($attribute, 'Booking time must be between 9 AM and 5 PM.');
        }
    }

    public function getRepair()
    {
        return $this->hasOne(Repair::class, ['id' => 'repair_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'repair_id' => 'Repair ID',
            'date' => 'Date',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }
}