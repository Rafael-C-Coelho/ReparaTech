<?php

namespace common\models;

use Exception;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use PhpMqtt\Client\MqttClient;

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

    /**
     * @throws ConnectingToBrokerFailedException
     * @throws ConfigurationInvalidException
     * @throws RepositoryException
     * @throws ProtocolNotSupportedException
     * @throws DataTransferException
     */
    public function afterSave($insert, $changedAttributes)
    {
        $brokerAddr = 'test.mosquitto.org';
        $brokerPort = 1883;
        $clientHash = md5(base64_encode($this->repair->client->email));

        /*
        try {
            $client = new MQTTClient($brokerAddr, $brokerPort);

            $client->connect();
            $client->publish('reparatech/client_' . $clientHash, json_encode(
                [
                    'repair_id' => $this->repair_id,
                    'description' => $this->description,
                    'date' => $this->date,
                    'time' => $this->time,
                ]
            ), 0, 1);
            $client->disconnect();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            throw $e;
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        */
    }

}
