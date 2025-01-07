<?php

namespace common\models;

use common\models\Repair;
use Yii;
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
            [['date', 'time', 'client_id'], 'required'],

            // Data type rules
            [['status'], 'string'],

            // Date and time validation
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['time', 'time', 'format' => 'php:H:i'],
            ['date', 'validateFutureDate'],

            // Working hours validation (assuming 9 AM to 6 PM)
            ['time', 'validateWorkingHours'],

            // Status validation
            ['status', 'in', 'range' => [
                self::STATUS_REQUESTED,
                self::STATUS_CONFIRMED,
                self::STATUS_CANCELLED,
                self::STATUS_DENIED
            ]],

            // Foreign key validation
            [['client_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['client_id' => 'id']
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

    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'date' => 'Date',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (isset(Yii::$app->params["supportEmail"])) {
            if ($this->status === self::STATUS_CONFIRMED) {
                // Send email notification to the client
                Yii::$app->mailer->compose(['html' => 'bookingConfirmed-html', 'text' => 'bookingConfirmed-text'], ['booking' => $this, 'user' => $this->client])
                    ->setTo($this->client->email)
                    ->setSubject('Booking Confirmed')
                    ->send();
            } elseif ($this->status === self::STATUS_DENIED) {
                // Send email notification to the client
                Yii::$app->mailer->compose(['html' => 'bookingDenied-html', 'text' => 'bookingDenied-text'], ['booking' => $this, 'user' => $this->client])
                    ->setTo($this->client->email)
                    ->setSubject('Booking Denied')
                    ->send();
            } else {
                Yii::$app->mailer->compose(['html' => 'bookingRequested-html', 'text' => 'bookingRequested-text'], ['booking' => $this, 'user' => $this->client])
                    ->setTo($this->client->email)
                    ->setSubject('Booking Requested')
                    ->send();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}