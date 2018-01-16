<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $habitList \app\models\dao\HabitList */
/* @var $model app\models\dao\Habit */

$this->title = 'Přidat návyk';
$this->params['breadcrumbs'][] = ['label' => 'Mé buzer-lístky', 'url' => ['/habit-list/index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $habitList->id, 'url' => ['/habit-list/view', 'id' => $habitList->id]];
$this->params['breadcrumbs'][] = ['label' => 'Upravit', 'url' => ['/habit-list/update', 'id' => $habitList->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
