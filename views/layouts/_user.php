<?php

/* @var $this \yii\web\View */

use app\models\dao\User;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$user = User::logged();
echo Nav::widget([
    'options' => ['class' => 'navbar-nav  justify-content-end'],
    'activateParents' => true,
    'items' => [
        [
            'label' => $user->email, 'linkOptions' => ['aria-expanded' => 'false'],
            'items' => [
                //['label' => 'Můj profil', 'url' => ['profile/index'],],
                ['label' => 'Odhlásit se', 'url' => ['site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]
        ]
    ],
]);
?>