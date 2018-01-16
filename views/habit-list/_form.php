<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dao\HabitList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="habit-list-form">

    <?php $form = ActiveForm::begin([
        'id' => 'habit-list-form',
        'layout' => 'horizontal',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'template' => "{label}<div class=\"col-md-9\">{input}{error}</div>",
            'labelOptions' => ['class' => 'col-md-3 col-form-label'],
        ]]); ?>
            <?php $model->switchToCzechDateFormat() ?>
            <?= $form->field($model, 'period')->widget('kartik\daterange\DateRangePicker', [
                'model' => $model,
                'startAttribute' => 'since',
                'endAttribute' => 'until',
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'DD.MM.YYYY'
                    ],
                    'opens' => $model->isNewRecord?'right':'left',
                ]
            ]) ?>
            <?= $form->field($model, 'note')->textarea(['maxlength' => 255]) ?>
            <div class="form-group offset-md-3">
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Uložit buzer-lístek',
                        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

    <?php ActiveForm::end(); ?>
</div>
