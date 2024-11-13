<?php

namespace common\models;

use common\models\Budget;
use common\models\RepairPart;
use common\models\User;

/**
 * This is the model class for table "repairs".
 *
 * @property int $id
 * @property string $device
 * @property string $progress
 * @property int $repairman_id
 * @property int $client_id
 * @property string $status
 * @property string $description
 *
 * @property Budget[] $budgets
 * @property User $client
 * @property User $repairman
 * @property RepairPart[] $repairsHasParts
 */
class Repair extends \yii\db\ActiveRecord
{

    const STATUS_PENDING_ACCEPTANCE = "Pending Acceptance";
    const STATUS_CREATED = "Created";
    const STATUS_DENIED = "Denied";
    const STATUS_IN_PROGRESS = "In Progress";
    const STATUS_COMPLETED = "Completed";


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'repairs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device', 'progress', 'repairman_id', 'client_id', 'description'], 'required'],
            [['device', 'progress', 'description'], 'string'],
            [['repairman_id', 'client_id'], 'integer'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[Budgets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBudgets()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)["repairTechnician"])) {
            return $this->hasMany(Budget::class, ['repair_id' => 'id'])->where(["repairman_id" => \Yii::$app->user->id]);
        }
        return $this->hasMany(Budget::class, ['repair_id' => 'id']);
    }

    /**
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::class, ['repair_id' => 'id']);
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
        return $this->hasMany(RepairPart::class, ['repair_id' => 'id']);
    }

    public static function getRepairs()
    {
        if (isset(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id)["repairTechnician"])) {
            return Repair::find()->where(["repairman_id" => \Yii::$app->user->id])->all();
        }
        return Repair::find()->all();
    }
}
