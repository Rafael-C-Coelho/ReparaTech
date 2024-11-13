<?php

namespace common\models;

use app\models\Repairs;
use app\models\Sales;

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
            [['total'], 'number'],
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
