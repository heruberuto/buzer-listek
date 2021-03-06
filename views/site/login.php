<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\forms\LoginForm */

use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Přihlášení';
$this->params['breadcrumbs'][] = $this->title;
$this->params['hideLogin'] = true;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Pro přihlášení je potřeba vyplnit následující údaje:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-1\"></div><div class=\"col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>
    <div class="form-group row">
        <div class="col-lg-1"></div>
        <div class="col-lg-11">
            <?= Html::submitButton('Přihlásit se', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['site/auth'],
                'autoRender' => false,
                'options' => ['class' => 'inline']
            ]); ?>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <?= $authAuthChoice->clientLink($client,
                    '<img src="' . Url::to(['/images/facebook.svg']) . '" alt="facebook"/>Přihlásit se přes facebook',
                    ['class' => 'btn btn-facebook']) ?>
            <?php endforeach; ?>
            <?php AuthChoice::end(); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
