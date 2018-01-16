<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dao\Habit */


$this->title = 'Upravit návyk: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mé buzer-lístky', 'url' => ['/habit-list/index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->habit_list_id, 'url' => ['/habit-list/view', 'id' => $model->habit_list_id]];
$this->params['breadcrumbs'][] = ['label' => 'Upravit', 'url' => ['/habit-list/update', 'id' => $model->habit_list_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
