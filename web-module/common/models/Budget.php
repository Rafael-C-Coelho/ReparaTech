<?php

namespace common\models;

use common\models\BudgetsHasParts;
use common\models\Repairs;

/**
 * This is the model class for table "{{%budgets}}".
 *
 * @property int $id
 * @property float $value
 * @property string $date
 * @property string $time
 * @property int $repair_id
 * @property int $repairman_id
 *
 * @property BudgetsHasParts[] $budgetsHasParts
 * @property Repair[] $repairs
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
            [['value', 'date', 'time', 'repair_id', 'repairman_id'], 'required'],
            [['value', 'repair_id', 'repairman_id'], 'number'],
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
            'repair_id' => 'Repair ID',
        ];
    }

    /**
     * Gets query for [[BudgetsHasParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetsHasParts()
    {
        return $this->hasMany(BudgetPart::class, ['budget_id' => 'id']);
    }

    /**
     * Gets query for [[Repairs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::class, ['budget_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $repair = Repair::find()->where(['id' => $this->repair_id])->one();
        $this->client_id = $repair->client_id;
        if ($repair->progress !== Repair::STATUS_PENDING_ACCEPTANCE) {
            $repair->progress = Repair::STATUS_PENDING_ACCEPTANCE;
            $repair->save();
        }
        return parent::beforeSave($insert);
    }
}
