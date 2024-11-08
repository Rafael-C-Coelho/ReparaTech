<?php

namespace common\models;

use app\models\Budgets;
use app\models\Invoices;
use app\models\RepairsHasParts;
use app\models\User;

/**
 * This is the model class for table "{{%repairs}}".
 *
 * @property int $id
 * @property string $device
 * @property string $progress
 * @property int $repairman_id
 * @property int $client_id
 * @property int $budget_id
 * @property int $invoice_id
 *
 * @property Budgets $budget
 * @property User $client
 * @property Invoices $invoice
 * @property User $repairman
 * @property RepairsHasParts[] $repairsHasParts
 */
class Repair extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%repairs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device', 'progress', 'repairman_id', 'client_id', 'budget_id', 'invoice_id'], 'required'],
            [['device', 'progress'], 'string'],
            [['repairman_id', 'client_id', 'budget_id', 'invoice_id'], 'integer'],
            [['budget_id'], 'exist', 'skipOnError' => true, 'targetClass' => Budgets::class, 'targetAttribute' => ['budget_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoices::class, 'targetAttribute' => ['invoice_id' => 'id']],
            [['repairman_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['repairman_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device' => 'Device',
            'progress' => 'Progress',
            'repairman_id' => 'Repairman ID',
            'client_id' => 'Client ID',
            'budget_id' => 'Budget ID',
            'invoice_id' => 'Invoice ID',
        ];
    }

    /**
     * Gets query for [[Budget]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudget()
    {
        return $this->hasOne(Budgets::class, ['id' => 'budget_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Invoice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoices::class, ['id' => 'invoice_id']);
    }

    /**
     * Gets query for [[Repairman]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairman()
    {
        return $this->hasOne(User::class, ['id' => 'repairman_id']);
    }

    /**
     * Gets query for [[RepairsHasParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairsHasParts()
    {
        return $this->hasMany(RepairsHasParts::class, ['repair_id' => 'id']);
    }
}
