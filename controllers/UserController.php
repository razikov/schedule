<?php

namespace app\controllers;

use app\models\User;
use app\models\UserForm;
use app\models\UserSearch;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['actions' => ['index'], 'allow' => true, 'roles' => [User::USER_LIST]],
                    ['actions' => ['create'], 'allow' => true, 'roles' => [User::USER_CREATE]],
                    ['actions' => ['update'], 'allow' => true, 'roles' => [User::USER_UPDATE]],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['model' => $model];
        }

        return ['form' => $this->renderPartial('_form', ['model' => $model])];
    }

    /**
     * @param $id
     * @return array
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = UserForm::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
        if (!Yii::$app->user->can(User::USER_UPDATE, ['model' => $model])) {
            throw new ForbiddenHttpException();
        }
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['model' => $model];
        }

        return ['form' => $this->renderPartial('_form', ['model' => $model])];
    }

    /**
     * @param $id
     * @return Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     */
//    public function actionLogin($id)
//    {
//        $model = User::findIdentity($id);
//        if (!$model) {
//            throw new NotFoundHttpException('Пользователь не найден');
//        }
//        if (!\Yii::$app->user->login($model, 3600 * 24)) {
//            throw new ErrorException('Ошибка при авторизации');
//        }
//
//        return $this->goHome();
//    }
}
