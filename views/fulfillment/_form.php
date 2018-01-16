<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\dao\Fulfillment */
/* @var $form yii\widgets\ActiveForm */
/* @var $noscript boolean */

$prefix = 'fulfillment_' . $model->habit_id . '_';
if ($noscript) {
    $prefix .= 'noscript_';
}
?>
<div<?= $noscript ? '' : ' class="modal fade"' ?> id="<?= $prefix ?>modal" tabindex="-1" role="dialog"
                                                  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= Html::encode($model->lazyHabit->name) ?>
                    <small><?= Yii::$app->formatter->asDate($model->day) ?></small>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Zavřít">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin(['action' => ['fulfillment/save'], 'options' => ['class' => 'fulfillment-form']]); ?>
            <div class="modal-body">
                <p><em><?= $model->getHabitNote() ?></em><strong>Podmínka
                        splnění: </strong><?= $model->getConditionString() ?></p>

                <?= $form->field($model, 'habit_id')->hiddenInput(['id' => $prefix . 'habit_id'])->label(false) ?>

                <?= $form->field($model, 'day')->hiddenInput(['id' => $prefix . 'day'])->label(false) ?>
                <div class="autofocus-wrapper">
                    <?= $model->renderField($form->field($model, 'value'), ['id' => $prefix . 'value']); ?>
                </div>
                <?= $form->field($model, 'note')->textarea(['id' => $prefix . 'note', 'maxlength' => 255,'placeholder'=>'Volitelná, max. 255 znaků.']) ?>

                <?= $form->field($model, 'excused')->checkbox(['id' => $prefix . 'excused']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Uložit', ['id' => $prefix . '_button', 'class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>