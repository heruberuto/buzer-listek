<?php

namespace app\controllers;

use app\models\dao\HabitList;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use app\models\dao\Habit;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HabitController implements the CRUD actions for Habit model.
 */
class HabitController extends Controller
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => Habit::className(),
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Finds the Habit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Habit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Habit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Habit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param null $habitList
     * @return mixed
     */
    public function actionCreate($habitList = null)
    {
        $habitList = HabitList::findOne($habitList);
        if (!isset($habitList)) {
            Yii::$app->session->addFlash('alert', 'Nevíme, ke kterému buzer-lístku se snažíte přidat návyk.');
            return $this->goBack();
        }
        $model = new Habit($habitList);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['habit-list/update', 'id' => $habitList->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'habitList' => $habitList
            ]);
        }
    }

    /**
     * Updates an existing Habit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['habit-list/update', 'id' => $model->habit_list_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Habit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['habit-list/update', 'id' => $model->habit_list_id]);
    }
}
