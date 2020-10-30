<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\HelperHealthSignIn;

/* @var $this yii\web\View */
/* @var $model common\models\HelperHealthSignIn */

$this->title = '健康打卡提醒';
$this->params['breadcrumbs'][] = ['label' => '我的助手', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert alert-info">
    <a href="#" class="close" data-dismiss="alert">
        &times;
    </a>
    <strong>注意！</strong>无论你使用何种提示方式，请在收到提示消息之后点击消息中的一个链接，这个链接将告诉系统你已打卡完毕，否则系统将默认你并未打卡。而对于还未打卡的同学，系统将在<strong>九点四十分</strong>（这通常是第二节课下课时间）以<strong>邮件及短信</strong>给予当天的最后一次提示。

    <br><br>祝你好运。
</div>

<div class="helperhealthsignin-form">

    <?php if (!$model->getIsNewRecord()): ?>
        <div class="alert alert-warning">
            <a href="#" class="close" data-dismiss="alert">
                &times;
            </a>
            你已设置打卡提示，也许你想要修改？
        </div>
    <?php endif;?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'remind_type')->radioList([
        HelperHealthSignIn::TYPE_EMAIL => '邮件',
        HelperHealthSignIn::TYPE_MESSAGE => '短信',
        HelperHealthSignIn::TYPE_ALL => '邮件和短信',
    ])->hint('当使用邮件提示时，建议下载一款邮箱App例如 QQ邮箱 App，系统将向你的注册时使用邮箱中发送一封邮件，此时邮箱App会把这封邮件信息推送到你的手机，就像早晨手机QQ推送一位朋友道来的早安那般。而使用短信提示时，请务必是真实的手机号，这在右上角 我的->账户设置 可以设置。') ?>

    <?= $form->field($model, 'remind_time')->radioList([
        HelperHealthSignIn::TIME_SEVEN => '七点钟（这通常是你起床的时候）',
        HelperHealthSignIn::TIME_SEVEN_FIFTY => '七点五十（如果有课，这通常在你上交手机之前）',
        HelperHealthSignIn::TIME_EIGHT_FORTY_FIVE => '八点四十五（这通常是第一节课下课时）',
    ]) ?>

    <?= $form->field($model, 'is_open')->radioList([
        HelperHealthSignIn::IS_OPEN_YES => '开',
        HelperHealthSignIn::IS_OPEN_NO => '关',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('确定', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
