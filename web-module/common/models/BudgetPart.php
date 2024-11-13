<?php

namespace common\models;

use common\models\Budgets;
use common\models\Parts;

/**
 * This is the model class for table "{{%budgets_has_parts}}".
 *
 * @property int $id
 * @property int $budget_id
 * @property int $part_id
 * @property int $quantity
 *
 * @property Budgets $budget
 * @property Parts $part
 */
class BudgetPart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%budgets_has_parts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['budget_id', 'part_id', 'quantity'], 'required'],
            [['budget_id', 'part_id', 'quantity'], 'integer'],
            [['budget_id'], 'exist', 'skipOnError' => true, 'targetClass' => Budgets::class, 'targetAttribute' => ['budget_id' => 'id']],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parts::class, 'targetAttribute' => ['part_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'budget_id' => 'Budget ID',
            'part_id' => 'Part ID',
            'quantity' => 'Quantity',
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
     * Gets query for [[Part]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Parts::class, ['id' => 'part_id']);
    }
}
