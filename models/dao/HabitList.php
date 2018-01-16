<?php

namespace app\models\dao;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "habit_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $since
 * @property string $until
 * @property string $note
 * @property string $created_at
 *
 * @property Habit[] $habits
 * @property Habit $potential
 * @property User $user
 */
class HabitList extends ActiveRecord
{
    public $period;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->id;
    }

    /**
     * Returns a habit list that is being fulfilled by the logged user today
     * @return HabitList|null
     */
    public static function ongoing()
    {
        return self::intersecting(new Expression('NOW()'));
    }

    /**
     * Outputs a habit list that intersects given time period for the logged user.
     * @param $since
     * @param null $until
     * @param $except
     * @return array|HabitList|null
     */
    public static function intersecting($since, $until = null, $except = null)
    {
        $condition = ['and', ['<=', 'since', $since], ['>=', 'until', $since]];

        if ($until != null) {
            $condition = ['or', $condition, ['and', ['<=', 'since', $until], ['>=', 'until', $until]]];
        }
        if ($except != null) {
            $condition = ['and', $condition, ['<>', 'id', $except]];
        }
        return self::find()->andWhere($condition)->one();
    }

    /**
     * Returns an ActiveQuery of class User.
     * Assures that the logged user can only access his and his own habit-lists.
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->andWhere(['user_id' => Yii::$app->user->id]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'habit_list';
    }

    public function switchToCzechDateFormat()
    {
        if ($this->since == null) {
            $this->since = date('Y-m-d');
        }
        if ($this->until == null) {
            $this->until = date('Y-m-d', strtotime('+28 days'));
        }
        $this->since = Yii::$app->formatter->asDate($this->since);
        $this->until = Yii::$app->formatter->asDate($this->until);
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        foreach (['since', 'until'] as $date) {
            $this->$date = date('Y-m-d', Yii::$app->formatter->asTimestamp($this->$date));
        }
        return parent::beforeValidate();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'since', 'until', 'period'], 'required'],
            ['period', 'validatePeriod'],
            [['user_id'], 'integer'],
            [['since', 'until', 'created_at'], 'safe'],
            [['note'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * Performs a check whether the
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validatePeriod($attribute, $params, $validator)
    {
        if (self::intersecting($this->since, $this->until, $this->id) != null) {
            $this->addError($attribute, 'Období se překrývá s jiným buzer-lístkem.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'period' => 'Období',
            'user_id' => 'Uživatel',
            'since' => 'Začátek',
            'until' => 'Konec',
            'note' => 'Poznámka',
            'created_at' => 'Čas vytvoření',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabits()
    {
        return $this->hasMany(Habit::className(), ['habit_list_id' => 'id'])
            ->andOnCondition(['not', ['condition_json' => null]]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPotential()
    {
        return $this->hasOne(Habit::className(), ['habit_list_id' => 'id'])
            ->andOnCondition(['condition_json' => null]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return int the count of the days in this habitlist
     */
    public function getDaysCount()
    {
        return intval((strtotime($this->until) - strtotime($this->since)) / 86400);
    }

    /**
     * @param $i
     * @return false|int timestamp of the i-th day of this habit-list
     */
    public function getIthDay($i)
    {
        return strtotime($this->since . " +$i days");
    }

    /**
     * @return float number of the days that passed since this habitlist started
     */
    public function getDaysFromStart()
    {
        return floor((time() - strtotime($this->since)) / 86400);
    }

    /**
     * @inheritdoc
     * Assures that the initial habit "Potential of the day" is created after the habitlist initialization
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            (new Habit([
                'habit_list_id' => $this->id,
                'condition_json' => null,
                'note' => 'Zhodnoť svůj dojem z tohoto dne na škále od 0 do 10',
                'name' => 'Potenciál dne'
            ]))->save(false);
        }
        parent::afterSave($insert, $changedAttributes);
    }

}
