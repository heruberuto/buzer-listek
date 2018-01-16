<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\dao\HabitList */

$this->title = 'Buzer-lístek #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mé buzer-lístky', 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;
?>
<div class="habit-list-view">
    <div class="jumbotron jumbotron-habit-list mb-0">
        <div class="container">
            <h1 class="display-3"><?= 'B<span class="hidden-xs">uzer</span>-L<span class="hidden-xs">ístek</span> #' .
                $model->id ?></h1>
            <p><?= Html::encode($model->note) ?>
                <br/><em>Od <?= Html::tag('strong', Yii::$app->formatter->asDate($model->since)) ?>
                    do <?= Html::tag('strong', Yii::$app->formatter->asDate($model->until)) ?></em></p>
            <p><?= Html::a('<i class="fa fa-pencil"></i> Upravit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-trash"></i> Odstranit', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Opravdu chcete odstranit tento buzer-lístek?',
                        'method' => 'post',
                    ],
                ]) ?></p>
        </div>
    </div>

    <?= $this->render('_table', ['model' => $model]); ?>

</div>
