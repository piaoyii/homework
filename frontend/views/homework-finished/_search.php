<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\HomeworkFinishedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="homework-finished-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'homework_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'finished_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'view_times') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'file_download_times') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
