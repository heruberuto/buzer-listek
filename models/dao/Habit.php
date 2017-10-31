<?php

namespace app\models\dao;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "habit".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $since
 * @property string $until
 * @property string $name
 * @property string $condition
 *
 * @property Fulfillment[] $fulfillments
 * @property User $user
 */
class Habit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'habit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'since', 'until', 'name', 'condition'], 'required'],
            [['user_id'], 'integer'],
            [['since', 'until'], 'safe'],
            [['name', 'condition'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID návyku',
            'user_id' => 'Uživatel',
            'user' => 'Uživatel',
            'since' => 'Začátek návyku',
            'until' => 'Konec návyku',
            'name' => 'Název',
            'condition' => 'Podmínka splnění',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFulfillments()
    {
        return $this->hasMany(Fulfillment::className(), ['habit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
