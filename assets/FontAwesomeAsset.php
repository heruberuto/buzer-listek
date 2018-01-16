<?php

namespace app\assets;


use yii\web\AssetBundle;

/**
 *
 * Class FontAwesomeAsset
 * Loads the Font awesome dependency
 * @package app\assets
 * @author Herbert Ullrich <ja@bertik.net>
 */
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