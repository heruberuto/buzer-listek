<?php

namespace app\models\dao;

use Yii;

/**
 * This is the model class for table "fulfillment".
 *
 * @property integer $id
 * @property string $day
 * @property integer $habit_id
 * @property string $value
 * @property string $note
 * @property integer $color
 *
 * @property Habit $habit
 */
class Fulfillment extends \yii\db\ActiveRecord
{
    const COLOR_RED = 0;
    const COLOR_GREEN = 1;
    const COLOR_BLUE = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fulfillment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'habit_id', 'value', 'note', 'color'], 'required'],
            [['day'], 'safe'],
            [['habit_id', 'color'], 'integer'],
            [['value'], 'string', 'max' => 32],
            [['note'], 'string', 'max' => 128],
            ['color', 'in', 'range' => [self::COLOR_RED, self::COLOR_GREEN, self::COLOR_BLUE]],
            [['habit_id', 'day'], 'unique', 'targetAttribute' => ['habit_id', 'day'], 'message' => 'The combination of Den and Návyk has already been taken.'],
            [['habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Habit::className(), 'targetAttribute' => ['habit_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID plnění',
            'day' => 'Den',
            'habit_id' => 'Návyk',
            'value' => 'Hodnota',
            'note' => 'Poznámka',
            'color' => 'Barva vyhodnocení',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabit()
    {
        return $this->hasOne(Habit::className(), ['id' => 'habit_id']);
    }
}
