<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->real_name ?>,

请打卡！

<?php //echo $verifyLink ?>
