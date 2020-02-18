<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\InfoCourseSearch;
use app\models\InfoCourseThemesSearch;
use app\models\ReservationClassroom;
use app\models\ReferenceCourseClassroom;
use \app\models\InfoCourse;
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
                    ['actions' => ['index', 'themes-modal'], 'allow' => true, 'roles' => [User::SCHEDULE_COURSES_LIST]],
                    ['actions' => ['themes'], 'allow' => true, 'roles' => [User::SCHEDULE_THEMES_LIST]],
                    ['actions' => ['show'], 'allow' => true, 'roles' => [User::SCHEDULE_CLASSROOM_MAP]],
                    ['actions' => ['view-class'], 'allow' => true, 'roles' => [User::SCHEDULE_RESERVATION_VIEW]],
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
    
    
    public function actionPresentation($dateAt = null)
    {
        $dateAt = $dateAt ? $dateAt : date("d.m.Y");
        $date = \DateTime::createFromFormat('d.m.Y', $dateAt);
        $date = $date->format('Y-m-d');
        
        $items = \app\models\Schedule::create($date);
        
        return $this->render('presentation', [
            'courses' => $items,
            'dateAt' => $dateAt,
        ]);
    }
    
    public function actionPresentationBlank()
    {
        $this->layout = 'blank';
        
        $items = \app\models\Schedule::create(date('Y-m-d'));
        
        return $this->render('presentationBlank', [
            'courses' => $items,
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
                $classroom = \yii\helpers\ArrayHelper::getValue(\app\models\Classroom::getList(), $item->classroom->classroom);
                $path = Yii::$app->user->can(User::SCHEDULE_RESERVATION_UPDATE) ? 'schedule-info/update-class' : 'schedule-info/view-class';
                $url = [
                    $path, 
                    'id' => $item->classroom->id,
                ];
            } else {
                $classroom = "Не выбрана";
                $path = Yii::$app->user->can(User::SCHEDULE_RESERVATION_CREATE) ? 'schedule-info/create-class' : 'schedule-info/view-class';
                $url = [
                    $path,
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
    
    public function actionViewClass($id = null, $IDCourse = null, $Order1 = null)
    {   
        if ($IDCourse && $Order1) {
            $model = new ReservationClassroom();
            $flag = $model->setCompositeKey($IDCourse, $Order1);

            if ($flag === null) {
                throw new NotFoundHttpException();
            }
        }
        if ($id) {
            $model = ReservationClassroom::findOne($id);
            
            if (!$model) {
                throw new NotFoundHttpException();
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['form' => $this->renderPartial('_form_view_class', ['model' => $model])];
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
