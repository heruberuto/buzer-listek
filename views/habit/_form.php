<?php

use app\models\conditions\Condition;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\dao\Habit */
/* @var $form yii\bootstrap\ActiveForm */

$js = <<<JS
function displayProperForm() {
  if($("#type").val()==='boolean'){
      lastTypeWasBoolean = true;
      $("#obvious-on-boolean").hide();
      $("#limit").val(1);
      $("#comparator").val('==');
      $("#unit").val('');
  }else{
      $("#obvious-on-boolean").show();
  }
}
displayProperForm();
$("#type").change(displayProperForm);
JS;

$this->registerJs($js);
?>

<div class="habit-form row">
    <div class="col-lg-6">
        <?php $form = ActiveForm::begin(['id' => 'habit-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}<div class=\"col-md-9\">{input}{error}</div>",
                'labelOptions' => ['class' => 'col-md-3 col-form-label'],
            ]]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 32, 'placeholder' => 'např. zdravé jídlo']) ?>

        <?= $form->field($model->condition, 'type')->dropDownList(Condition::TYPES, ['id' => 'type']) ?>
        <div id="obvious-on-boolean">
            <?= $form->field($model->condition, 'comparator')->dropDownList(Condition::COMPARATORS, ['id' => 'comparator']) ?>

            <?= $form->field($model->condition, 'limit')->textInput(['placeholder' => 'např. 5', 'id' => 'limit']) ?>

            <?= $form->field($model->condition, 'unit')->textInput(['placeholder' => 'např. 0..10', 'id' => 'unit']) ?>
        </div>

        <?= $form->field($model, 'note')->textarea(['maxlength' => 255, 'placeholder' => 'libovolná do 255 znaků']) ?>


        <div class="form-group offset-md-3">
            <?= Html::submitButton('<i class="fa fa-floppy-o"></i> Uložit návyk', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
