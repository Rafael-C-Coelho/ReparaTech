<?php

namespace common\models;

use app\models\Parts;
use app\models\Repairs;

/**
 * This is the model class for table "{{%repairs_has_parts}}".
 *
 * @property int $id
 * @property int $repair_id
 * @property int $part_id
 * @property int $quantity
 *
 * @property Parts $part
 * @property Repairs $repair
 */
class RepairPart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%repairs_has_parts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repair_id', 'part_id', 'quantity'], 'required'],
            [['repair_id', 'part_id', 'quantity'], 'integer'],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parts::class, 'targetAttribute' => ['part_id' => 'id']],
            [['repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repairs::class, 'targetAttribute' => ['repair_id' => 'id']],
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
            'part_id' => 'Part ID',
            'quantity' => 'Quantity',
        ];
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

    /**
     * Gets query for [[Repair]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepair()
    {
        return $this->hasOne(Repairs::class, ['id' => 'repair_id']);
    }
}
