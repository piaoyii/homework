<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$title = '账号资料：' . $model->username;
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email',
            'qq',
            'phone',
            'real_name',
            'created_at:datetime',
            'updated_at:datetime',
            'last_login_at',
        ],
    ]) ?>

</div>
