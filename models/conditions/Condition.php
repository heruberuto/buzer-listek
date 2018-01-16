<?php

namespace app\models\conditions;


use app\models\dao\Fulfillment;
use app\models\dao\HabitList;
use JsonSerializable;
use Yii;
use yii\base\Model;

/**
 * Class Condition
 *
 * JSON serializable class that processes user's data (cells of the habit table) and evaluates whether the planned criteria
 * has been satisfied.
 * Holds data that determine the values in the habit table header.
 * It's one-to-one related to Habit and in the suggested DB model, it exists as its field.
 *
 * Nevertheless, the complexity of evaluating various dynamic data and holding various custom criteria in a computer exact form
 * makes this the least stable part of the project. Updating the Habit Conditions system should be as agile as possible,
 * hence the JSONable solution.
 * @package app\models\conditions
 * @author Herbert Ullrich <ja@bertik.net>
 */
class Condition extends Model implements JsonSerializable
{
    const POTENTIAL_OF_THE_DAY = null;

    const SATISFIED = 1;
    const DISSATISFIED = 2;
    const EXCUSED = 3;
    const IRRELEVANT = 4;
    const EMPTY = 0;

    const COMPARATORS = ['>=' => 'minimálně', '<=' => 'maximálně', '==' => 'přesně'];
    const TYPES = ['boolean' => 'splněno/nesplněno', 'weekly' => 'splnit n-krát za týden', 'number' => 'číslo', 'time' => 'čas'];

    public $comparator;
    public $type;
    public $limit;
    public $unit;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [["comparator", "type", "limit"], "required"],
            ["comparator", "in", "range" => array_keys(self::COMPARATORS)],
            ["type", "in", "range" => array_keys(self::TYPES)],
            ["limit", "safe"],
            [["unit"], "string"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if ($this->type == 'time') {
            $this->limit = \Yii::$app->formatter->asTime($this->limit);
        } else {
            $this->limit = floatval($this->limit);
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            "comparator" => "Význam limitu",
            "type" => "Typ záznamů",
            "limit" => "Limit",
            "unit" => "Jednotka/škála",
        ];
    }

    /**
     * Converts given Condition object to a human language formulation of the condition.
     * Used in views.
     * @return string human language representation
     */
    public function __toString()
    {
        if ($this->type == 'boolean') {
            return 'denně';
        } else if ($this->type == null) {
            return '[0..10]';
        }
        $appendix = '';
        if ($this->type == 'weekly') {
            $appendix = '× týdně';
        } else if (isset($this->unit) && strlen($this->unit)) {
            $appendix = ' [' . $this->unit . ']';
        }
        return $this->getComparatorChar() . ' ' . $this->limit . $appendix;
    }

    /**
     * Converts the stored two-character-comparator to a single-character. Used to achieve friendliness with non-programmers.
     * @return string single character comparator
     */
    public function getComparatorChar()
    {
        switch ($this->comparator) {
            case '>=':
                return '≥';
            case '<=':
                return '≤';
            case '==':
                return '=';
            default:
                return $this->comparator;
        }
    }

    /**
     * Given a Fulfillment object, compute its success rate
     * @param $fulfillment Fulfillment
     * @param bool $computeWeekly whether weekly condition should be evaluated over the entire week or just today.
     * @return int
     */
    public function evaluate($fulfillment, $computeWeekly = false)
    {
        if ($this->type == null) {
            return $this->evaluatePotential($fulfillment->lazyHabit->habitList, $fulfillment->day);
        }
        if ($this->type == 'weekly' && $computeWeekly) {
            return $this->evaluateWeekly($fulfillment);
        }
        if ($fulfillment->value == null && $this->type != 'weekly') {
            return self::EMPTY;
        }
        if ($this->compare($fulfillment->value, $this->type == 'weekly' ? 1 : $this->limit)) {
            return self::SATISFIED;
        }
        if ($this->type == 'weekly') {
            return self::IRRELEVANT;
        }
        if ($fulfillment->excused) {
            return self::EXCUSED;
        }
        return self::DISSATISFIED;
    }


    /**
     * @param $habitList HabitList
     * @param $day
     * @return int
     */
    public function evaluatePotential($habitList, $day)
    {
        $acceptable = [self::SATISFIED, self::EXCUSED];
        foreach ($habitList->habits as $habit) {
            $habitEvaluation = $habit->condition->evaluate(Fulfillment::getInstance($habit, $day), true);
            if ($habitEvaluation == self::EMPTY) {
                return self::EMPTY;
            }
            if (!in_array($habitEvaluation, $acceptable)) {
                return self::DISSATISFIED;
            }
        }
        return self::SATISFIED;
    }


    /**
     * @param $fulfillment Fulfillment
     * @return int
     */
    public function evaluateWeekly($fulfillment)
    {
        $habitList = $fulfillment->lazyHabit->habitList;
        $daysBetween = (strtotime($fulfillment->day) - strtotime($habitList->since)) / 86400;
        $firstDayOffset = $daysBetween - ($daysBetween % 7);
        $firstDay = date('Y-m-d', strtotime($habitList->since . " +$firstDayOffset days"));
        $lastDay = date('Y-m-d', strtotime("$firstDay +6 days"));
        //Yii::trace($firstDay . '-' . $lastDay);
        return $this->compare(
            Fulfillment::find()
                ->where(['habit_id' => $fulfillment->habit_id])
                ->andWhere(['between', 'day', $firstDay, $lastDay])
                ->sum('value'),
            floatval($this->limit)
        ) ? self::SATISFIED : ($lastDay > date('Y-m-d') ? self::EMPTY : self::DISSATISFIED);


    }

    public function compare($a, $b)
    {
        if ($this->type == 'time') {
            $a = strval($a);
            $b = strval($b);
        } else {
            $a = floatval($a);
            $b = floatval($b);
        }

        switch ($this->comparator) {
            case '>=':
                return $a >= $b;
            case '<=':
                return $a <= $b;
            default:
                return $a == $b;
        }
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}