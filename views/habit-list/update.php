<?php

use himiklab\sortablegrid\SortableGridView;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\dao\HabitList */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Buzer-lístek #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mé buzer-lístky', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Upravit';
?>
<div class="habit-list-update">

    <h1><i class="fa fa-pencil"></i> <?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-7 habits">
            <h2>Návyky</h2>
            <?= SortableGridView::widget([
                'dataProvider' => $dataProvider,
                'sortableAction' => ['habit/sort'],
                'layout' => "{items}",
                'columns' => [
                    'name',
                    'condition',
                    'note',
                    ['class' => 'app\components\ActionColumn', 'controller' => 'habit', 'template' => '{update} {delete}'],
                ],
            ]); ?>
            <p>
                <?= Html::a(
                    '<i class="fa fa-plus-circle"></i> Přidat návyk',
                    ['/habit/create', 'habitList' => $model->id],
                    ['class' => 'btn btn-success']) ?>
                <span class="float-right">Počet návyků: <strong><?= $dataProvider->totalCount ?></strong></span>
            </p>
        </div>
        <div class="col-lg-5"><h2>Nastavení buzer-lístku</h2>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?></div>
    </div>

</div>
