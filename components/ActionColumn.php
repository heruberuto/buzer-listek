<?php

namespace app\components;


use Yii;

/**
 * Class ActionColumn
 * @package app\components
 * @author Herbert Ullrich <ja@bertik.net>
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Initializes the default button rendering callbacks.
     * Adds altering between glyphicons and font awesome
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open fa fa-eye');
        $this->initDefaultButton('update', 'pencil fa fa-pencil');
        $this->initDefaultButton('delete', 'trash fa fa-trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }
}