<?php

/* @var $this yii\web\View */

use app\models\dao\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = 'My Yii Application';
$this->params['fullWidth'] = true;
?>
<div class="site-index">
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 class="display-3">Vítej!</h1>
                    <p class="lead">You have successfully created your Yii-powered application.</p>
                    <!--p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p-->
                </div>
                <div class="col-lg-5" style="">
                    <?php $form = ActiveForm::begin([
                        'id' => 'sign-up-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-md-9\">{input}{error}</div>",
                            'labelOptions' => ['class' => 'col-md-3 col-form-label'],
                        ]]); ?>
                    <h3>Nemáš účet? Založ si ho!</h3>
                    <?= $form->field($signUpForm, 'email')->input('email', ['maxlength' => true, 'placeholder' => 'váš@e-mail.cz']) ?>
                    <?= $form->field($signUpForm, 'password')->passwordInput(['maxlength' => true, 'placeholder' => 'alespoň 6 znaků']) ?>
                    <?= $form->field($signUpForm, 'password_repeat')->passwordInput(['maxlength' => true, 'placeholder' => 'shodné s předchozím']) ?>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <?= Html::submitButton('Založit účet', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>


                    <?php ActiveForm::end(); ?></div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h2>Prokrastinace</h2>
                    <p>Se budují zhruba 30 dní, proto je nutné blabla
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu
                        fugiat nulla pariatur.</p>
                    <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a>
                    </p>
                </div>
                <div class="col-lg-4">
                    <h2>Návyky</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Heading</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions
                            &raquo;</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
