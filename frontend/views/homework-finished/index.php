<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HomeworkFinishedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $homework null or common\models\Homework */

$title = '作业完成列表';
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => '/homework/index'];
if (!empty($homework)) {
    $this->params['breadcrumbs'][] = ['label' => '第' . $homework->order . '次', 'url' => '/homework/index?HomeworkSearch[id]=' . $homework->id];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homework-finished-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($searchModel->homework_id) echo Html::a('我也来！', ['create?homework_id=' . $searchModel->homework_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'homework_id',
            'real_name',
            //'content_md:ntext',
            'finished_at',
            'updated_at',
            'view_times',
            //'file',
            //'file_download_times',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if ($model->user_id == Yii::$app->user->id) {
                            return '<a href="' . $url . '" title="更新" aria-label="更新" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
                        } else {
                            return ;
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        if ($model->user_id == Yii::$app->user->id) {
                            return '<a href="' . $url . '" title="删除" aria-label="删除" data-pjax="0" data-confirm="您确定要删除本次作业吗？您也可以修改。" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                        } else {
                            return ;
                        }
                    },
                ],
            ],
        ],
    ]); ?>


</div>
