<?php

/* @var $this yii\web\View */
/* @var $model common\models\HomeworkFinish */
/* @var $homework common\models\Homework */
/* @var $user common\models\User */
/* @var $upload frontend\models\UploadForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\HtmlPreviewMarkdownToHtmlAsset;
HtmlPreviewMarkdownToHtmlAsset::register($this);


$this->registerCss('
    .editormd-html-preview {
        width: 90%;
        margin: 0 auto;
    }
');

$this->title = '第' . $homework->order . '次';
$this->params['breadcrumbs'][] = ['label' => 'Java作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = '作者：' . $user->real_name;

?>
    <div id="layout">
        <header>
            <h1>第 <?php echo $homework->order?> 次
                <br>
                <br>
                作业内容：
                <br>
                <br>
                <?php echo nl2br($homework->content)?>
            </h1>
            <?php if ($homework->is_image):?>
                    <a href="<?= Yii::$app->params['backendBaseUrl'] . '/homework/download?id=' . $homework->id; ?>">本次作业是图片，点我下载</a>
            <?php endif;?>
            <h2>
                作者：<?php echo $user->real_name;?>
            </h2>

            <?php
                if ($model->user_id == Yii::$app->user->id) {
                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

                    echo $form->field($upload, 'file')->fileInput()->hint('若已上传过文件再次上传将覆盖原文件！若作业文件数量不止一个，请打包压缩之后再上传！');

                    echo '<div class="form-group">' .
                        Html::submitButton("确定", ["class" => "btn btn-success"])
                    . '</div>';

                    ActiveForm::end();
                }

                if (!empty($model->file)) {
                    echo Html::a('有配套作业文件哦！点我下载！', ['download', 'id' => $model->id]);
                } else {
                    echo Html::a('还没有配套代码文件～');
                }
            ?>
        </header>

        <div id="editormd-view">
            <textarea id="append-test" style="display:none;"><?php echo $model->content_md;?></textarea>
        </div>
    </div>
<?php

$this->registerJs('
    $(function() {
        var editormdView;

        editormdView = editormd.markdownToHTML("editormd-view", {
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            emoji           : true,
            taskList        : true,
            tex             : true,  // 默认不解析
            flowChart       : true,  // 默认不解析
            sequenceDiagram : true,  // 默认不解析
        });
    });
')
?>
