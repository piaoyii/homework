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

    <p>
        <?= Html::a('布置作业', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order',
            'content:ntext',
            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
