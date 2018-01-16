<?php

namespace app\models\dao;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Html;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $created_at
 * @property boolean $has_admin_rights
 *
 * @property integer $habitListsCount
 * @property HabitList[] $habitLists
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return User
     */
    public static function logged()
    {
        if (Yii::$app->user->identity instanceof User) {
            return Yii::$app->user->identity;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['has_admin_rights'], 'boolean'],
            [['password'], 'string', 'min' => 6],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'password' => 'Heslo',
            'auth_key' => 'Autorizační klíč (Yii2)',
            'created_at' => 'Čas registrace',
            'has_admin_rights' => 'Má autorská práva',
            'habitListsCount' => 'Buzer-lístků',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabitLists()
    {
        return $this->hasMany(HabitList::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function __toString()
    {
        return Html::a($this->email, ['/user/view', 'id' => $this->id]);
    }

    public function getHabitListsCount()
    {
        return Yii::$app->db->createCommand('SELECT count(*) FROM `habit_list` WHERE `user_id` = :id', ['id' => $this->id])->queryScalar();
    }
}
