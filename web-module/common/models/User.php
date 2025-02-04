<?php

namespace common\models;

use common\models\FavoriteProduct;
use Faker\Factory;
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
 * @property string $nif
 * @property string $address
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

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            [
                'name' => "Name"
            ]
        );
    }
    public function rules()
    {
        return [
            [['username', 'email','name'], 'required'],
            ['password', 'required', 'on' => 'create'],
            [['nif', 'address', 'contact'], 'required', 'on' => self::SCENARIO_CLIENT],
            [['value'], 'required', 'on' => self::SCENARIO_REPAIR_TECHNICIAN],
            [['username', 'email', 'name', 'nif', 'address', 'contact'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['username'], 'unique', 'message' => 'This username is already taken.'],
            [['email'], 'unique', 'message' => 'This email is already registered.'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9_\-]{4,20}$/', 'message' => 'Username can only contain alphanumeric characters, underscores, or dashes, and must be between 4 and 20 characters.'],
            [['name'], 'match', 'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]{1,100}$/u', 'message' => 'Name can only contain letters, spaces, and hyphens.'],
            [['password'], 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/',
                'message' => 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'],
            [['nif'], 'match', 'pattern' => '/^\d{9}$/', 'message' => 'NIF must be a 9-digit number.'],
            [['address'], 'string', 'min' => 5, 'message' => 'Address must be at least 5 characters long.'],
            [['status'], 'in', 'range' => [self::STATUS_DELETED, self::STATUS_AWAITING_ACTIVATION, self::STATUS_INACTIVE, self::STATUS_ACTIVE],
                'message' => 'Invalid status value.'],
            [['value'], function ($attribute, $params, $validator) {
                if ($this->scenario === self::SCENARIO_REPAIR_TECHNICIAN && !is_numeric($this->$attribute)) {
                    $this->addError($attribute, 'Value must be a number for repair technicians.');
                }
            }],
        ];
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
        if ($password === null) {
            return;
        }
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

    /*
     * Gets the favorited products
     */
    public function getFavoriteProducts()
    {
        return FavoriteProduct::find()->where(['user_id' => $this->id]);
    }

    /*
     * Gets the count of favorited products
     */
    public function getFavoriteProductsCount()
    {
        return $this->getFavoriteProducts()->count();
    }

    /*
     * Check if product is already in the user's favorites
     */
    public function hasFavoriteProduct($product) {
        return $this->getFavoriteProducts()->where(['product_id' => $product->id])->exists();
    }

    /*
     * Add product to user's favorites
     */
    public function addFavoriteProduct($product)
    {
        $favoriteProduct = new FavoriteProduct();
        $favoriteProduct->user_id = $this->id;
        $favoriteProduct->product_id = $product->id;
        $favoriteProduct->save();
    }

    /*
     * Remove product from user's favorites
     */
    public function removeFavoriteProduct($product)
    {
        $favoriteProduct = $this->getFavoriteProducts()->where(['product_id' => $product->id])->one();
        $favoriteProduct->delete();
    }

    public static function getClients()
    {
        $authManager = Yii::$app->authManager;
        $clients = [];

        // Get all users with the "client" role
        foreach ($authManager->getUserIdsByRole('client') as $userId) {
            $user = User::findOne($userId);
            if ($user) {
                $clients[$user->id] = $user->name; // assuming 'name' is a user field
            }
        }

        return $clients;
    }

    public static function getRepairTechnicians()
    {
        $authManager = Yii::$app->authManager;
        $clients = [];

        // Get all users with the "client" role
        foreach ($authManager->getUserIdsByRole('repairTechnician') as $userId) {
            $user = User::findOne($userId);
            if ($user) {
                $clients[$user->id] = $user->name; // assuming 'name' is a user field
            }
        }

        return $clients;
    }

    public function getRoles()
    {
        $authManager = Yii::$app->authManager;
        $roles = array_keys($authManager->getRolesByUser($this->id));
        return $roles;
    }

    public function hasRole($role)
    {
        return isset(Yii::$app->authManager->getRolesByUser($this->id)[$role]);
    }

    public function delete()
    {
        $this->status = self::STATUS_DELETED;
        $this->name = "Deleted User";
        $this->email = random_int(1000000000, 9999999999) . "@deleted.com";
        $this->username = "" . random_int(1000000000, 9999999999);
        $this->password_hash = Yii::$app->security->generatePasswordHash(random_int(1000000000, 9999999999));
        $this->auth_key = "";
        $this->nif = "";
        $this->address = "";
        $this->refresh_token = "";
        return $this->save();
    }
}
