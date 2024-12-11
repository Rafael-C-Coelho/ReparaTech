<?php

namespace common\models;

use common\models\Repair;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $id
 * @property int $repair_id
 * @property resource|null $photo
 * @property string|null $description
 *
 * @property Repair $repair
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
            [['repair_id'], 'exist', 'skipOnError' => true, 'targetClass' => Repair::class, 'targetAttribute' => ['repair_id' => 'id']],
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
        return $this->hasOne(Repair::class, ['id' => 'repair_id']);
    }

    public function beforeSave($insert)
    {
        $this->time = date('H:i:s');
        $this->date = date('Y-m-d');
        return parent::beforeSave($insert);
    }
}
