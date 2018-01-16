<?php

/* @var $this \yii\web\View */

/* @var $content string
 */

use app\assets\AppAsset;
use app\models\dao\HabitList;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

if (!isset($this->params['fullWidth'])) {
    $this->params['fullWidth'] = false;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to(['/images/favicons/']) ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to(['/images/favicons/']) ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to(['/images/favicons/']) ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= Url::to(['/images/favicons/']) ?>/manifest.json">
    <link rel="mask-icon" href="<?= Url::to(['/images/favicons/']) ?>/safari-pinned-tab.svg" color="#f02137">
    <meta name="theme-color" content="#F02238">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-red">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                <img src="<?= Url::to(['/images/logo.svg']) ?>" alt="Smajlík" id="logo">
                <span>Buzer-lístek</span>
                <small class="version">BETA</small>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavigation"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavigation">
                <?= Nav::widget([
                    'options' => ['class' => 'navbar-nav mr-auto'],
                    'items' => [
                        ['label' => 'Úvod', 'url' => ['/site/index'], 'visible' => Yii::$app->user->isGuest],
                        ['label' => 'Plnění', 'url' => ['/site/index'], 'visible' => HabitList::ongoing() != null],
                        ['label' => 'Mé buzer-lístky', 'url' => ['/habit-list/index'], 'visible' => !Yii::$app->user->isGuest],
                        ['label' => 'Správa uživatel', 'url' => ['/user/index'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->has_admin_rights],
                        ['label' => 'O projektu', 'url' => ['/site/about']],
                        ['label' => 'Dokumentace', 'url' => ['/site/doc']],
                    ],
                ]);
                ?>
                <?= Yii::$app->user->isGuest && !isset($this->params['hideLogin']) ? $this->render('_login') : '' ?>
                <?= !Yii::$app->user->isGuest ? $this->render('_user') : '' ?>
            </div>
        </nav>
    </header>
    <?= Alert::widget() ?>
    <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
        <?= Breadcrumbs::widget([
            'tag' => 'ol',
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active" aria-current="page">{link}</li>',
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => ['class' => 'breadcrumb container']
        ]) ?>
    </nav>
    <?= Html::tag('main', $content, $this->params['fullWidth'] ? [] : ['class' => 'container']) ?>
</div>

<footer class="footer">
    <div class="container">
        <span class="float-left">
             &copy; <strong><a href="http://bertik.net">Herbert Ullrich</a></strong> <?= date('Y') ?>
        </span>
        <span class="float-right text-muted"><?= Yii::powered() ?></span>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
