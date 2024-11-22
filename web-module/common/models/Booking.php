<?php

namespace common\models;

use app\models\Repairs;

/**
 * This is the model class for table "{{%Bookings}}".
 *
 * @property int $id
 * @property int $repair_id
 * @property string $date
 * @property string $time
 * @property string $status
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Bookings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repair_id', 'date', 'time'], 'required'],
            [['repair_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['status'], 'string'],
            [['repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repairs::class, 'targetAttribute' => ['repair_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
}
