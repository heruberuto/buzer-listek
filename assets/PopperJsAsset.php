<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 28.10.2017
 * Time: 16:59
 */

namespace app\assets;


use yii\web\AssetBundle;

class PopperJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/popper.js/dist/umd';
    public $js = [
        'popper.min.js',
    ];
}