<?php

namespace app\controllers;

use app\models\dao\HabitList;
use app\models\dao\User;
use app\models\forms\LoginForm;
use app\models\forms\SignUpForm;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'oAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionHabitList();
        } else {
            return $this->actionSignUp();
        }
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    private function actionHabitList()
    {
        $model = HabitList::ongoing();
        if ($model == null) {
            Yii::$app->session->addFlash('info', '<strong>Vítej!</strong> Nemáš dnes nastaven žádný buzer-lístek. Vytvoř si ho!');
            return $this->redirect(['/habit-list/']);
        }
        return $this->render('/habit-list/ongoing', ['model' => $model]);
    }

    private function actionSignUp()
    {
        $model = new SignUpForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['/site/index']);
        }
        return $this->render('index', [
            'signUpForm' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionDoc()
    {
        return $this->render('doc');
    }

    /**
     * This function will be triggered when user is successfuly authenticated using some oAuth client.
     *
     * @param yii\authclient\ClientInterface $client
     * @return boolean|yii\web\Response
     */
    public function oAuthSuccess($client)
    {
        $email = ($client->getUserAttributes())['email'];
        $user = User::findOne(['email' => $email]);
        if ($user == null) {
            $user = new User(['email' => $email, 'password' => Yii::$app->security->generateRandomString()]);
            $user->save();
        }
        Yii::$app->session->setFlash('Byl jste úspěšně přihlášen přes Facebook');
        return Yii::$app->user->login($user, 3600 * 24 * 30);
    }
}
