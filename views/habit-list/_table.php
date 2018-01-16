<?php
//TODO: rewrite using GridView
use app\models\dao\Fulfillment;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/**
 * @param $string
 * @return string
 */
function e($string)
{
    return Yii::$app->formatter->asNtext($string);
}

$smileys = [Url::to(['/images/smile.svg']), Url::to(['/images/frown.svg']), Url::to(['/images/wink.svg'])];
/* @var $this yii\web\View */
/* @var $model app\models\dao\HabitList */
$this->params['fullWidth'] = true;
$fulfillments = [];
$habits = $model->habits;
if ($model->potential != null) {
    $habits[] = $model->potential;
}
?>
<noscript>
    <h2>Dnešní plnění návyků</h2>
    <div class="row">
        <?php
        foreach ($habits as $habit) {
            echo Html::tag('div', $this->render('/fulfillment/_form', ['noscript' => true, 'model' => Fulfillment::getInstance($habit)]), ['class' => 'col-md-3']);
        }
        ?>
    </div>
</noscript>
<?php
foreach ($habits as $habit) {
    echo $this->render('/fulfillment/_form', ['noscript' => false, 'model' => Fulfillment::getInstance($habit)]);
}
?>
<table class="table table-fixed-header table-striped table-bordered habit-list">
    <thead class="thead-light borderless">
    <tr>
        <th>Den</th>
        <?php
        foreach ($habits as $habit) {
            echo Html::tag('th', e($habit->name));
        }
        ?>
    </tr>
    <tr>
        <td></td>
        <?php
        foreach ($habits as $habit) {
            echo Html::tag('td', $habit->condition, ['data' => ['note' => $habit->note]]);
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i = 0; $i <= $model->getDaysCount(); $i++) {
        $timestamp = $model->getIthDay($i);
        $date = date('Y-m-d', $timestamp);
        ?>
        <tr <?= $date == date('Y-m-d') ? 'class=" table-primary"' : '' ?>>
            <th><?= date('j.n.', $timestamp) ?></th>
            <?php
            foreach ($habits as $habit) {
                echo time() >= $timestamp ? Fulfillment::getInstance($habit, $date)->toCell() : '<td></td>';
            }
            ?>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
