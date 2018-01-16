<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mé buzer-lístky';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="habit-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Přidat buzer-lístek', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin()?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id:integer',
            'since:date',
            'until:date',
            'note:ntext',
            'created_at:datetime',
            ['class' => 'app\components\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end()?>
</div>
