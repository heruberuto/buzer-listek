<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 13.01.2018
 * Time: 18:23
 */

namespace app\assets;


use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}