<?php

namespace app\models\dao;

use app\models\conditions\Condition;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "fulfillment".
 *
 * @property integer $id
 * @property string $day
 * @property string $value
 * @property integer $habit_id
 * @property string $note
 * @property integer $excused
 * @property string $created_at
 *
 * @property Habit $habit
 * @property Habit $lazyHabit
 */
class Fulfillment extends \yii\db\ActiveRecord
{
    const BOOLEAN_OPTIONS = ['nesplněno', 'splněno'];
    const EMOTICON_ONLY_TYPES = ['boolean', 'weekly'];
    const EVALUATION_REPRESENTATION = [
        Condition::SATISFIED => ['splněno', 'smile.svg'],
        Condition::DISSATISFIED => ['nesplněno', 'frown.svg'],
        Condition::EXCUSED => ['omluveno', 'wink.svg'],
    ];

    private $_habit;

    public function __construct($config = [])
    {
        if ($config instanceof Habit) {
            $this->_habit = $config;
            $this->habit_id = $this->_habit->id;
        } else {
            parent::__construct($config);
        }
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fulfillment';
    }

    public static function getInstance($habit, $day = null)
    {
        if ($day == null) {
            $day = date('Y-m-d');
        }
        $result = self::findOne(['habit_id' => $habit->id, 'day' => $day]);
        if ($result == null) {
            $result = new Fulfillment($habit);
            $result->day = $day;
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['day', 'value', 'habit_id'], 'required'],
            [['day'], 'safe'],
            [['habit_id'], 'integer'],
            ['excused', 'boolean'],
            [['note'], 'string', 'max' => 255],
            [['habit_id', 'day'], 'unique', 'targetAttribute' => ['habit_id', 'day'], 'message' => 'The combination of Den v buzer-lístku and Návyk has already been taken.'],
            [['habit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Habit::className(), 'targetAttribute' => ['habit_id' => 'id']],
        ], $this->habitSpecificRules($this->lazyHabit));
    }

    /**
     * @param $habit Habit
     * @return array
     */
    public function habitSpecificRules($habit)
    {
        switch ($habit->condition->type) {
            case null:
                return [
                    ['value', 'number'],
                    ['value', 'compare', 'compareValue' => 10, 'operator' => '<='],
                    ['value', 'compare', 'compareValue' => 0, 'operator' => '>='],
                ];
            case 'weekly':
            case 'boolean':
                return [['value', 'boolean']];
            case 'time':
                return [['value', 'validateTime']];
            default:
                return [['value', 'number']];
        }
    }

    /**
     * @param $attribute string Name of field to be validated
     * @param $params array Unused. Pro forma.
     * @param $validator object Unused. Pro forma.
     */
    public function validateTime($attribute, $params, $validator)
    {
        try {
            $this->$attribute = Yii::$app->formatter->asTime($this->$attribute);
        } catch (InvalidParamException $exception) {
            $this->addError($attribute, 'Čas není strojově čitelný');
        }
    }

    public function getLazyHabit()
    {
        if (isset($this->_habit)) {
            return $this->_habit;
        }
        return $this->habit;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => 'Den v buzer-lístku',
            'value' => 'Vyplněná hodnota',
            'habit_id' => 'Návyk',
            'note' => 'Poznámka',
            'excused' => 'Z objektivních důvodů nemožno splnit (např. nemoc)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabit()
    {
        return $this->hasOne(Habit::className(), ['id' => 'habit_id']);
    }


    /**
     * @param $field ActiveField
     * @return ActiveField
     */
    public function renderField($field, $options = [])
    {
        switch ($this->lazyHabit->condition->type) {
            case 'weekly':
            case 'boolean':
                return $field->dropDownList(self::BOOLEAN_OPTIONS, $options);
            case null:
                return $field->textInput(ArrayHelper::merge(['type' => 'number'], $options));
            default:
                return $field->textInput(ArrayHelper::merge(['maxlength' => 255], $options));
        }
    }

    public function toCell()
    {
        $condition = $this->lazyHabit->condition;
        $evaluation = $condition->evaluate($this);

        $content = !in_array($condition->type, self::EMOTICON_ONLY_TYPES) ?
            Html::encode($this->value) . $this->getEmoticon($evaluation) :
            $this->getEmoticon($evaluation, true);

        return Html::tag('td',
            $content,
            [
                'class' => 'fulfillment-cell' . ($evaluation == Condition::IRRELEVANT ? ' crossed' : ''),
                'data' => [
                    'day' => $this->day,
                    'value' => $this->value,
                    'note' => $this->note,
                    'excused' => $this->excused,
                    'habit_id' => $this->habit_id
                ]
            ]
        );
    }

    public function getEmoticon($evaluation, $centered = false)
    {
        if (!array_key_exists($evaluation, self::EVALUATION_REPRESENTATION)) {
            return '';
        }
        $representation = self::EVALUATION_REPRESENTATION[$evaluation];
        return '<img src="' . Url::to(['/images/' . $representation[1]]) . '"
         class="emoticon' . ($centered ? ' centered' : '') . '" alt="' . $representation[0] . '"/>';
    }

    public function getConditionString()
    {
        return $this->lazyHabit->isGeneric() ? 'Všechny ostatní návyky jsou splněny, nebo nesplněny z objektivních důvodů.' : $this->lazyHabit->condition->__toString();
    }

    public function getHabitNote()
    {
        return $this->lazyHabit->note != null ? Html::encode($this->lazyHabit->note) . '<br/>' : '';
    }
}
