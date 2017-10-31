<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 28.10.2017
 * Time: 16:54
 */

namespace app\assets;


use yii\bootstrap\BootstrapAsset;

class Bootstrap4Asset extends BootstrapAsset
{
    public $css = [
        'css/bootstrap.min.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
    ];
    public $depends = [
        'app\assets\PopperJsAsset',
    ];
}