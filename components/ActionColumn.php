<?php
/**
 * Created by PhpStorm.
 * User: herbe
 * Date: 13.01.2018
 * Time: 18:37
 */

namespace app\components;


use Yii;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Initializes the default button rendering callbacks.
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