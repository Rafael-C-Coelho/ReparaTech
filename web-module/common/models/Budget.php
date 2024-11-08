<?php

namespace common\models;

use app\models\BudgetsHasParts;
use app\models\Repairs;

/**
 * This is the model class for table "{{%budgets}}".
 *
 * @property int $id
 * @property float $value
 * @property string $date
 * @property string $time
 *
 * @property BudgetsHasParts[] $budgetsHasParts
 * @property Repairs[] $repairs
 */
class Budget extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%budgets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'date', 'time'], 'required'],
            [['value'], 'number'],
            [['date', 'time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'date' => 'Date',
            'time' => 'Time',
        ];
    }

    /**
     * Gets query for [[BudgetsHasParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetsHasParts()
    {
        return $this->hasMany(BudgetsHasParts::class, ['budget_id' => 'id']);
    }

    /**
     * Gets query for [[Repairs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repairs::class, ['budget_id' => 'id']);
    }
}
