<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Homework */

$this->title = '布置作业';
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homework-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
