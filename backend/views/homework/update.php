<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Homework */

$this->title = '修改：' . $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->created_at, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="homework-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
