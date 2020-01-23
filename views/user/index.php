<?php
/**
 * @var $this yii\web\View
 * @var $searchModel app\models\UserSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $dealers \app\models\Dealer[]
 */

use app\models\User;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

\app\assets\JqueryDatePickerAsset::register($this);
$this->title = Yii::t('app', 'Список пользователей');
//$this->registerJs('UserList(' . Json::encode($params) . ');');
$this->registerJs('
    bindModal(".js-show-modal", {
        beforeShow: function (_modal) {
            selectpicker(_modal);
        }
    });
');
?>
    <h2 class="page-title"><?= $this->title ?></h2>
<?php if (\Yii::$app->user->can(User::USER_CREATE) || True) : ?>
    <?= Html::a(Yii::t('app', 'Новый пользователь'), ['create'], ['class' => 'btn btn-primary js-show-modal']) ?>
<?php endif ?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'columns' => [
        'id',
        'email',
        [
            'attribute' => 'role',
//            'format' => 'role',
            'header' => Yii::t('app', 'Роль'),
        ],
        [
            'attribute' => 'fullName',
        ],
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'visibleButtons' => [
                'update' => function ($model, $key, $index) {
                    return \Yii::$app->user->can(User::USER_UPDATE, ['model' => $model]);
                },
            ],
            'buttons' => [
                'update' => function ($url, $model) {
                    return \Yii::$app->user->can(User::USER_UPDATE, ['model' => $model]) ?
                        Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,
                            ['class' => 'js-show-modal', 'title' => Yii::t('app', 'Редактировать')]
                        ) : '';
                },
            ],
        ],
    ],
]); ?>