<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $role
 * @property string $name
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_AWAITING_ACTIVATION = 8;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const SCENARIO_MANAGER = 'manager';
    const SCENARIO_STORE_OWNER = 'storeOwner';
    const SCENARIO_CLIENT = 'client';
    const SCENARIO_REPAIR_TECHNICIAN = 'repairTechnician';

    public $password;
    public $name;
    public $nif;
    public $address;
    public $contact;
    public $value;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            ['status', 'default', 'value' => self::STATUS_AWAITING_ACTIVATION],
            ['status', 'in', 'range' => [self::STATUS_AWAITING_ACTIVATION, self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            // Manager-specific rules
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            [['password'], 'required', 'on' => self::SCENARIO_MANAGER],

            // Store owner-specific rules
            [['password'], 'required', 'on' => self::SCENARIO_STORE_OWNER],

            // Client-specific rules
            [['password', 'nif', 'address', 'contact'], 'required', 'on' => self::SCENARIO_CLIENT],

            // Repairman-specific rules
            [['password', 'value'], 'required', 'on' => self::SCENARIO_REPAIR_TECHNICIAN],
        ]);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_MANAGER] = ['username', 'email', 'password', 'name'];
        $scenarios[self::SCENARIO_STORE_OWNER] = ['username', 'email', 'password', 'name'];
        $scenarios[self::SCENARIO_CLIENT] = ['username', 'email', 'password', 'name', 'nif', 'address', 'contact'];
        $scenarios[self::SCENARIO_REPAIR_TECHNICIAN] = ['username', 'email', 'password', 'name', 'value'];
        return $scenarios;
    }

    public function setScenarioBasedOnRole($role="")
    {
        if ($role) {
            if ($role === 'manager') {
                $this->scenario = self::SCENARIO_MANAGER;
            } elseif ($role === 'storeOwner') {
                $this->scenario = self::SCENARIO_STORE_OWNER;
            } elseif ($role === 'client') {
                $this->scenario = self::SCENARIO_CLIENT;
            } elseif ($role === 'repairTechnician') {
                $this->scenario = self::SCENARIO_REPAIR_TECHNICIAN;
            }
            return;
        }

        $auth = Yii::$app->authManager;
        if ($auth->checkAccess($this->id, 'manager')) {
            $this->scenario = self::SCENARIO_MANAGER;
        } elseif ($auth->checkAccess($this->id, 'storeOwner')) {
            $this->scenario = self::SCENARIO_STORE_OWNER;
        } elseif ($auth->checkAccess($this->id, 'client')) {
            $this->scenario = self::SCENARIO_CLIENT;
        } elseif ($auth->checkAccess($this->id, 'repairTechnician')) {
            $this->scenario = self::SCENARIO_REPAIR_TECHNICIAN;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_AWAITING_ACTIVATION
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
