<?php

/* @var $this yii\web\View */

use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Buzer-lístek';
$this->params['fullWidth'] = true;
?>
<div class="site-index">
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 class="display-3">Vítej!</h1>
                    <p class="lead">Buzer-lístek je jednoduchá metoda, která poslouží k budování návyků. Sepište si
                        činnosti, které chcete dělat, třeba cvičit, zdravě jíst nebo více číst, a každý den kontrolujte
                        jejich plnění. Získáte tak i podrobný zpětný přehled o plnění úkolů. S každým návykem, který se
                        nám daří dělat, naše vůle sílí.</p>
                    <!--p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p-->
                </div>
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'sign-up-form',
                        'layout' => 'horizontal',
                        'enableAjaxValidation' => true,
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-md-9\">{input}{error}</div>",
                            'labelOptions' => ['class' => 'col-md-3 col-form-label'],
                        ]]); ?>
                    <h3>Nemáš účet? Založ si ho!</h3>
                    <?= $form->field($signUpForm, 'email')->input('email', ['maxlength' => 64, 'placeholder' => 'váš@e-mail.cz']) ?>
                    <?= $form->field($signUpForm, 'password')->passwordInput(['placeholder' => 'alespoň 6 znaků']) ?>
                    <?= $form->field($signUpForm, 'password_repeat')->passwordInput(['placeholder' => 'shodné s předchozím']) ?>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <?= Html::submitButton('Založit účet', ['class' => 'btn btn-success']) ?>
                            <div class="float-right"><?php $authAuthChoice = AuthChoice::begin([
                                    'baseAuthUrl' => ['site/auth'], 'autoRender' => false
                                ]); ?>
                                <?php foreach ($authAuthChoice->getClients() as $client): ?>
                                    <?= $authAuthChoice->clientLink($client,
                                        '<img src="' . Url::to(['/images/facebook.svg']) . '" alt="facebook"/><span class="hidden-xs">Vstoupit přes facebook</span>',
                                        ['class' => 'btn btn-facebook']) ?>
                                <?php endforeach; ?>
                                <?php AuthChoice::end(); ?></div>

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
                    <p>je výrazná a chronická tendence odkládat plnění (většinou administrativních či <strong>psychicky
                            náročných</strong>)
                        povinností a úkolů (zejména těch nepříjemných) na <strong>pozdější dobu</strong>. Může
                        představovat
                        rizikový fenomén pro duševní zdraví.</p>
                    <p><a class="btn btn-light btn-wiki" href="https://cs.wikipedia.org/wiki/Prokrastinace"><img
                                    src="<?=Url::to(['/images/wikipedia.svg'])?>" alt="Logo Wikipedie"/> Více na Wikipedii</a>
                    </p>
                </div>
                <div class="col-lg-4">
                    <h2>Návyk</h2>
                    <p>je ustálený vzorec chování jednotlivce nebo členů určitého společenství, zdůvodněný pouze tím, že
                        se
                        tak chovali vždycky, přinejmenším po delší dobu. Dodržování již zaběhnutého návyku nevede k
                        <strong>emoční averzi</strong> a tím i <strong>prokrastinaci</strong>. Návykem je tedy možné
                        zvýšit <strong>produktivitu</strong>.</p>

                    <p><a class="btn btn-light btn-wiki" href="https://cs.wikipedia.org/wiki/Zvyk"><img
                                    src="<?=Url::to(['/images/wikipedia.svg'])?>" alt="Logo Wikipedie"/> Více na Wikipedii</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Buzer-lístek</h2>
                    <p>je nástroj navržený <strong><a href="https://cs.wikipedia.org/wiki/Petr_Ludwig">Petrem
                                Ludwigem</a></strong>
                        v knize <strong><a href="https://www.konec-prokrastinace.cz/homepage/">Konec
                                prokrastinace</a></strong>.
                        Sami se rozhodnete, jaké návyky chcete budovat a jak budete hodnotit svůj úspěch. Buzer-lístek
                        Vám nabídne každodenní
                        <strong>upomínku</strong> toho, kam míříte a <strong>zpětnou vazbu</strong> o tom, jak se Vám
                        daří.</p>

                    <p><a class="btn btn-light btn-forbes"
                          href="http://www.forbes.cz/10-zasad-jak-posilovat-svou-vuli/">
                            <img src="<?=Url::to(['/images/forbes.svg'])?>" alt="Logo Forbesu"/> Více na Forbes.cz</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
