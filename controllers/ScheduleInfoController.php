<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\InfoCourseSearch;
use app\models\InfoCourseThemesSearch;
use app\models\ReservationClassroom;
use app\models\User;
use yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;

class ScheduleInfoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['presentation-blank'],
                'rules' => [
                    ['actions' => ['presentation'], 'allow' => true, 'roles' => ["@"]],
                    ['actions' => ['index'], 'allow' => true, 'roles' => [User::SCHEDULE_COURSES_LIST]],
                    ['actions' => ['themes', 'themes-modal'], 'allow' => true, 'roles' => [User::SCHEDULE_THEMES_LIST]],
                    ['actions' => ['show'], 'allow' => true, 'roles' => [User::SCHEDULE_CLASSROOM_MAP]],
                    ['actions' => ['create-class'], 'allow' => true, 'roles' => [User::SCHEDULE_RESERVATION_CREATE]],
                    ['actions' => ['update-class'], 'allow' => true, 'roles' => [User::SCHEDULE_RESERVATION_UPDATE]],
                    ['actions' => ['delete-class'], 'allow' => true, 'roles' => [User::SCHEDULE_RESERVATION_DELETE]],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new InfoCourseSearch();
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionThemes()
    {
        $searchModel = new InfoCourseThemesSearch();
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'Date1' => SORT_DESC,
            ]
        ];
        
        return $this->render('themes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionThemesModal($courseId)
    {
        $searchModel = new InfoCourseThemesSearch();
        $searchModel->IDCourse = $courseId;
        $course = InfoCourseSearch::findOne(['ID' => $courseId]);
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        return ['form' => $this->renderPartial('_modal_themes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'courseName' => $course->Name ? $course->Name : '',
        ])];
        
    }
    
    public function actionPresentation($date = null)
    {
        $date = $date ? $date : date("Y-m-d");
        $searchModel = new InfoCourseThemesSearch();
        $searchModel->Date1 = $date;
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        
        return $this->render('presentation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPresentationBlank($date = null)
    {
        $this->layout = 'blank';
        $date = $date ? $date : date("Y-m-d");
        $searchModel = new InfoCourseThemesSearch();
        $searchModel->Date1 = $date;
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        
        return $this->render('presentationBlank', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionShow()
    {
        $searchModel = new InfoCourseThemesSearch();
        $searchModel->Date1 = date("Y-m-d");
        
        $items = $searchModel->searchQuery(\Yii::$app->request->queryParams)
                ->orderBy(['Time1' => SORT_ASC])
                ->all();
        $result = [];
        foreach (\app\models\Classroom::getList() as $key=>$item) {
            $result[(string)$item] = [];
        }
        foreach($items as $item) {
            if ($item->classroom) {
                $classroom = $item->classroom->classroom;
                $url = ['schedule-info/update-class', 'id' => $item->classroom->id];
            } else {
                $classroom = "0";
                $url = [
                    'schedule-info/create-class',
                    'IDCourse' => $item->IDCourse,
                    'Order1' => $item->Order1,
                ];
            }
            $result[$classroom]["{$item->IDCourse}-{$item->Order1}"] = [
                'start' => $item->time,
                'end' => $item->endTime,
                'url' => $url,
                'hint' => $item->theme->Name,
            ];
        }
        $total = 0;
        foreach ($result as $item => $items) {
            $rows = count($items);
            if ($rows == 0) {
                $total += 1;
            } else {
                $total += $rows;
            }
        }
        
        return $this->render('show', [
            'searchModel' => $searchModel,
            'items' => $result,
            'total' => $total,
        ]);
    }
    
    public function actionCreateClass($IDCourse, $Order1)
    {   
        $model = new ReservationClassroom();
        $flag = $model->setCompositeKey($IDCourse, $Order1);
        
        if ($flag === null) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['model' => $model];
        } else {
            return ['form' => $this->renderPartial('_form_class', ['model' => $model])];
        }
    }
    
    public function actionUpdateClass($id)
    {
        $model = ReservationClassroom::findOne($id);
        
        if (!$model) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ['model' => $model];
        } else {
            return ['form' => $this->renderPartial('_form_class', ['model' => $model])];
        }
    }
    
    public function actionDeleteClass($id, $returnUrl)
    {
        $model = ReservationClassroom::findOne($id);
        
        if (!$model) {
            throw new NotFoundHttpException;
        }
        
        $model->delete();
        return $this->redirect($returnUrl);
        
//        Yii::$app->response->format = Response::FORMAT_JSON;
//        return ['success' => (int)$model->delete(), 'errors' => Html::errorSummary($model)];
    }

}