<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改：' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '账号资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'qq')->textInput() ?>

        <?= $form->field($model, 'phone')->textInput() ?>

        <?= $form->field($model, 'real_name')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
