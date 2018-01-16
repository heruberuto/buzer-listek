<?php

namespace app\models\dao;

use app\models\conditions\Condition;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;

/**
 * This is the model class for table "habit".
 *
 * @property integer $id
 * @property string $name
 * @property string $condition_json
 * @property string $note
 * @property integer $habit_list_id
 * @property string $created_at
 *
 * @property Fulfillment[] $fulfillments
 * @property HabitList $habitList
 * @property Condition $condition
 */
class Habit extends \yii\db\ActiveRecord
{
    private $_condition;

    public function __construct($config = [])
    {
        if($config instanceof HabitList){
            $this->habit_list_id = $config->id;
        }else{
            parent::__construct($config);
        }
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'habit';
    }

    public static function find()
    {
        return parent::find()->orderBy(['order' => SORT_ASC]);
    }

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'order'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'condition_json', 'habit_list_id'], 'required'],
            [['condition_json'], 'string'],
            [['habit_list_id','order'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['note'], 'string', 'max' => 255],
            [['habit_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => HabitList::className(), 'targetAttribute' => ['habit_list_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Návyk',
            'condition_json' => 'Podmínka splnění',
            'condition' => 'Podmínka splnění',
            'note' => 'Poznámka',
            'habit_list_id' => 'Buzer-lístek',
            'created_at' => 'Čas vytvoření',
        ];
    }

    public function load($data, $formName = null)
    {
        return $this->condition->load($data) && parent::load($data, $formName);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return $this->condition->validate() && parent::validate($attributeNames, $clearErrors);
    }

    public function beforeValidate()
    {
        $this->condition_json = json_encode($this->condition);
        return parent::beforeValidate();
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
    public function getHabitList()
    {
        return $this->hasOne(HabitList::className(), ['id' => 'habit_list_id']);
    }

    /**
     * @return Condition
     */
    public function getCondition()
    {
        if ($this->_condition == null) {
            $this->_condition = new Condition(json_decode($this->condition_json, true));
        }
        return $this->_condition;
    }
    public function isGeneric(){
        return $this->condition_json == null;
    }
}
