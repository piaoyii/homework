<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $callbackLink  回调链接 */

$callbackLink = Yii::$app->params['baseUrl'] . '/helper/health-sign-in-callback?token=' . $callbackToken;
?>
<div class="verify-email">
    <p>你好 <?= Html::encode($user->real_name) ?>，</p>

    <p>记得企业微信健康打卡哦！</p>

    <p><?php echo Html::a(Html::encode($callbackLink), $callbackLink) ?></p>
</div>
