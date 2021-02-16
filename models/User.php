<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Модель пользователя
 * @property int $id
 * @property string username
 * @property string auth_key
 * @property string password_hash
 * @property string password_reset_token
 * @property string email
 * @property int status
 * @property int created_at
 * @property int updated_at
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return \yii\helpers\ArrayHelper::merge(
            parent::rules(),
            [
                [['id', 'status', 'created_at', 'updated_at'], 'integer'],
                [['email'], 'email'],
                [['id', 'email', 'username'], 'unique'],
                [['username'], 'match', 'pattern' => '/[A-z0-9_-]/'],
                [['username'], 'string', 'min' => 2, 'max' => 64],
                [['password_hash'], 'string', 'min' => 6],
                [['password_hash'], 'filter', 'filter' => function ($value) {
                    return $this->isAttributeChanged('password_hash')
                        ? \Yii::$app->getSecurity()->generatePasswordHash($value)
                        : $value
                    ;
                }],
                [['auth_key',
                  'password_reset_token',
                  'verification_token'], 'string', 'length' => 32],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge(
            [
                \yii\behaviors\TimestampBehavior::className(),
                [
                    'class' => \yii\behaviors\AttributeBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT =>
                            ['auth_key', 'password_reset_token', 'verification_token'],
                    ],
                    'value' => function ($event) {
                        return bin2hex(random_bytes(16));
                    },
                ],
            ],
            parent::behaviors()
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}