<?php

/* @var $this \yii\web\View */

use app\models\forms\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$model = new LoginForm();

?>

    <!--form class="form-inline my-2 my-lg-0" method="post" action="<?= Url::to(['site/login']) ?>">
        <input class="form-control mr-sm-2" type="email" placeholder="E-mail" aria-label="E-mail"<?= LoginForm::className() ?>>
        <input class="form-control mr-sm-2" type="password" placeholder="Heslo" aria-label="Heslo">
        <button class="btn btn-outline-light my-2 my-sm-0" type="submit" id="loginButton">
            Přihlásit se
        </button>
    </form-->

<?php $form = ActiveForm::begin([
    'id' => 'header-login-form',
    'action' => Url::to(['site/login']),
    'layout' => 'inline',
    'fieldConfig' => [
        'template' => "{input}",
        'inputOptions' => ['class' => 'form-control mr-sm-2'],
        'options' => [
            'tag' => 'span'
        ],
    ],
]); ?>

<?= $form->field($model, 'email')->input('email', ['placeholder' => 'E-mail', 'class' => 'form-control mr-sm-2']) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Heslo', 'class' => 'form-control mr-sm-2']) ?>
<?= Html::submitButton('Přihlásit se', ['class' => 'btn btn-outline-light my-2 my-sm-0', 'name' => 'login-button']) ?>
<?php ActiveForm::end(); ?>