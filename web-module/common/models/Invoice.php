<?php

namespace common\models;

use common\models\Repairs;
use common\models\Sales;
use common\models\User;

/**
 * This is the model class for table "{{%invoices}}".
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $time
 * @property float|null $total
 *
 * @property Repair[] $repairs
 * @property Sale[] $sales
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%invoices}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'safe'],
            [['total'], 'number', 'min' => 0, 'max' => 1000000],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['repair_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'time' => 'Time',
            'repair_id' => 'Repair ID',
            'client_id' => 'Client ID',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[Repairs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repairs::class, ['invoice_id' => 'id']);
    }


    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    public function getRepair()
    {
        return $this->hasOne(User::class, ['id' => 'repair_id']);
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasMany(Sales::class, ['invoice_id' => 'id']);
    }
}
