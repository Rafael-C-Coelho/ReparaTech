<?php

namespace common\models;

use app\models\Repairs;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $id
 * @property int $repair_id
 * @property resource|null $photo
 * @property string|null $description
 *
 * @property Repairs $repair
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['repair_id'], 'required'],
            [['repair_id'], 'integer'],
            [['photo'], 'string'],
            [['description'], 'string', 'max' => 512],
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
            'photo' => 'Photo',
            'description' => 'Description',
            'recipient_id' => 'Recipient',
            'sender_id' => 'Sender',
        ];
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
