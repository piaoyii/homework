<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        //['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Java作业', 'url' => ['/homework/index']],
        /*['label' => 'Contact', 'url' => ['/site/contact']],*/
    ];

    $menuItems[] = '<li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">小帮手<span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="/helper/health-sign-in">健康打卡提醒</a></li>
                </ul>
                </li>';

    $menuItems[] = ['label' => '关于', 'url' => ['/site/about']];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '登陆', 'url' => ['/site/login']];
    } else {
        $li = '<li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">我的<span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="/user/index">账户设置</a></li>
                <li><a href="/homework-finished/index?HomeworkFinishedSearch[user_id]=' . Yii::$app->user->id . '">发表作品</a></li>
                <li class="divider"></li>
                <li><a href="/site/logout" data-method="post">'. '退出 (' . Yii::$app->user->identity->username . ')' . '</a></li>
                </ul>
                </li>';
        $menuItems[] = $li;
/*        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';*/
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right">技术支持：Piaoyii</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
