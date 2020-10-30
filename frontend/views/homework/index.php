<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HomeworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Java作业';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homework-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order',
            'content:ntext',
            'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {finished-list}',
                'buttons' => [
                    'finished-list' => function ($url, $model, $key) {
                        $url = '/homework-finished/index?HomeworkFinishedSearch[homework_id]=' . $model->id;
                        //echo $url;die;
                        return '<a href="' . $url . '" title="看看有谁完成了它！" aria-label="看看有谁完成了它！" data-pjax="0"><span class=" glyphicon glyphicon-th-list"></span></a>';
                    },
                ],
            ],
        ],
    ]); ?>


</div>
