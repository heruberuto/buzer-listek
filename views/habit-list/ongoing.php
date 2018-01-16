<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 28.10.2017
 * Time: 23:30
 */

use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\dao\HabitList */

$this->title = 'Buzer-lístek';
$this->params['fullWidth'] = true;
?>
<?php /*
    <div class="jumbotron jumbotron-habit-list nomargin">
        <div class="container">
            <h1 class="display-3 hidden-xs">Můj současný buzer-lístek</h1>
            <p><?= Html::encode($model->note) ?>
                <br/><em>Zbývá dní: <?= Html::tag('strong', $model->getDaysCount()-$model->getDaysFromStart()) ?>,
                    uběhlo: <?= Html::tag('strong', $model->getDaysFromStart()) ?></em></p>
            <p><?= Html::a('<i class="fa fa-pencil"></i> Upravit', ['habit-list/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-trash"></i> Odstranit', ['habit-list/delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Opravdu chcete odstranit tento buzer-lístek?',
                        'method' => 'post',
                    ],
                ]) ?></p>
        </div>
    </div>*/ ?>
<?= $this->render('_table', ['model' => $model]); ?>