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
            // Required fields
            [['value', 'date', 'time', 'description', 'repair_id', 'repairman_id', 'status', 'hours_estimated_working'], 'required',
                'message' => '{attribute} cannot be blank'],

            // Numeric validations
            [['value'], 'number',
                'min' => 0.01,
                'max' => 999999.99,
                'message' => 'Value must be between 0.01 and 999,999.99',
                'tooBig' => 'Value cannot exceed 999,999.99',
                'tooSmall' => 'Value must be at least 0.01'],

            [['hours_estimated_working'], 'number',
                'min' => 0.5,
                'max' => 168, // Maximum hours in a week
                'message' => 'Hours must be between 0.5 and 168',
                'tooBig' => 'Hours cannot exceed one week (168 hours)',
                'tooSmall' => 'Hours must be at least 30 minutes (0.5)'],

            // Integer validations
            [['repair_id', 'repairman_id'], 'integer',
                'message' => '{attribute} must be a whole number'],

            // String validations
            [['description'], 'string',
                'min' => 10,
                'max' => 1000,
                'tooShort' => 'Description must be at least 10 characters',
                'tooLong' => 'Description cannot exceed 1000 characters'],

            // Status validation
            [['status'], 'in',
                'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED],
                'message' => 'Invalid status value'],

            // Date and time validations
            ['date', 'date',
                'format' => 'php:Y-m-d',
                'message' => 'Invalid date format. Use YYYY-MM-DD'],

            ['time', 'match',
                'pattern' => '/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]$/',
                'message' => 'Invalid time format. Use HH:MM:SS'],

            // Date cannot be in the past
            ['date', 'validateDate'],

            // Foreign key validations
            [['repair_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Repair::class,
                'targetAttribute' => ['repair_id' => 'id'],
                'message' => 'Selected repair does not exist'],

            [['repairman_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['repairman_id' => 'id'],
                'message' => 'Selected repairman does not exist'],

            // Trim strings
            [['description'], 'trim'],

            // Filter out HTML
            [['description'], 'filter', 'filter' => 'strip_tags'],

            // Safe attributes
            [['created_at', 'updated_at'], 'safe']
        ];
    }

// Custom validation methods
    public function validateDate($attribute, $params)
    {
        if (strtotime($this->date) > strtotime(date('Y-m-d'))) {
            $this->addError($attribute, 'Date cannot be in the future');
        }
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
     * Gets query for [[Repairs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::class, ['budget_id' => 'id']);
    }

    public function getRepairman()
    {
        return $this->hasOne(User::class, ['id' => 'repairman_id']);
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
