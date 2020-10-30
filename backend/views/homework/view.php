<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Homework */
/* @var $uploadHomeworkImageForm backend\models\UploadHomeworkImageForm */

$this->title = $model->created_at;
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="homework-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a('删掉', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除？',
                'method' => 'post',
            ],
        ]);*/ ?>
    </p>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($uploadHomeworkImageForm, 'imageFile')->fileInput() ?>

        <div class="form-group"><?= Html::submitButton("确定", ["class" => "btn btn-success"]) ?></div>

    <?php ActiveForm::end() ?>

    <?php
        if ($model->is_image) {
            echo Html::a('本次作业是图片，点我下载', ['download', 'id' => $model->id]);
        }
    ?>
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
