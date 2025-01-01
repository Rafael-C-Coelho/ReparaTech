<?php

namespace common\models;

use common\models\BudgetsHasParts;
use common\models\Repair;
use Yii;

/**
 * This is the model class for table "{{%budgets}}".
 *
 * @property int $id
 * @property float $value
 * @property string $date
 * @property string $time
 * @property string $status
 * @property string $description
 * @property int $repair_id
 * @property int $repairman_id
 *
 * @property BudgetsHasParts[] $budgetsHasParts
 * @property Repair[] $repairs
 */
class Budget extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 'Pending';
    const STATUS_APPROVED = 'Approved';
    const STATUS_REJECTED = 'Rejected';

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
            [['value', 'date', 'time', 'description', 'repair_id', 'repairman_id', 'status', 'hours_estimated_working'], 'required'],
            [['value', 'repair_id', 'repairman_id', 'hours_estimated_working'], 'number'],
            [['status', 'description'], 'string'],
            [['value', 'hours_estimated_working'], 'safe'],
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
            'description' => 'Description',
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
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $repair = Repair::find()->where(['id' => $this->repair_id])->one();
        if ($this->status === self::STATUS_PENDING) {
            $repair->progress = Repair::STATUS_PENDING_ACCEPTANCE;
            $repair->save();
        }
        if ($this->status === self::STATUS_APPROVED) {
            $repair->progress = Repair::STATUS_IN_PROGRESS;
            $repair->save();
        }
        if ($this->status === self::STATUS_REJECTED) {
            $repair->progress = Repair::STATUS_DENIED;
            $repair->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
