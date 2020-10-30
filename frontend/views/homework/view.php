<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Homework */

$this->title = $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="homework-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->is_image):?>
            <a href="<?= Yii::$app->params['backendBaseUrl'] . '/homework/download?id=' . $model->id; ?>">本次作业是图片，点我下载</a>
    <?php endif;?>
    <br>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'content:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
