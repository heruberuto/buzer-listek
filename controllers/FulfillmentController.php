<?php

namespace app\controllers;

use app\models\dao\Fulfillment;
use app\models\dao\HabitList;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use app\models\dao\Habit;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * HabitController implements the CRUD actions for Habit model.
 */
class FulfillmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }


    public function actionSave()
    {
        $p = Yii::$app->request->post('Fulfillment');
        $habit = Habit::findOne($p['habit_id']);
        $day = $p['day'];
        $model = Fulfillment::getInstance($habit, $day);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                $result = ['status' => 1, 'cell' => $model->toCell()];
                if (!$habit->isGeneric()) {
                    $result['potentialCell'] = Fulfillment::getInstance($habit->habitList->potential, $day)->toCell();
                }
                return $result;
            }
            Yii::$app->session->addFlash('danger', '<strong>Úspěšně jsi vyplnil návyk.</strong> Můžeš pokračovat.');
        } else {
            if (Yii::$app->request->isAjax) {
                return ['status' => 0, 'errors' => $model->getErrorSummary(true)];
            }
            Yii::$app->session->addFlash('danger', '<strong>Nepodařilo se vyplnit návyk.</strong> Zkuste to prosím znovu.');
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
