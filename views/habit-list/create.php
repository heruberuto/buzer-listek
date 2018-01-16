<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\dao\HabitList */

$this->title = 'Vytvořit buzer-lístek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-list-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
