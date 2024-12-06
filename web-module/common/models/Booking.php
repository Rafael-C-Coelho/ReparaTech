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
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['time', 'time', 'format' => 'php:H:i'],
            [['status'], 'string'],
            [['repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Repair::class, 'targetAttribute' => ['repair_id' => 'id']],
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

    public function getRepair(){
        return $this->hasOne(\common\models\Repairs::class, ['id' => 'repair_id']);
    }



}
