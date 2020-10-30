<?php

/* @var $this yii\web\View */
/* @var $model common\models\HomeworkFinish */
/* @var $homework common\models\Homework */

use  yii\helpers\Url;

if ($model->getIsNewRecord()) {
    $url = Url::toRoute(['create', 'homework_id' => $homework->id]);
} else {
    $url = Url::toRoute(['update', 'id' => $model->id]);
}
?>
<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8" />
        <title>我来做它！</title>
        <link rel="stylesheet" href="/editor.md/css/style.css" />
        <link rel="stylesheet" href="/editor.md/css/editormd.css" />
    </head>
    <body>
        <div id="layout">
            <header>
                <h1>我来做它！</h1>
                <p><?php echo nl2br($homework->content)?></p>
                <?php if ($homework->is_image):?>
                        <a href="<?= Yii::$app->params['backendBaseUrl'] . '/homework/download?id=' . $homework->id; ?>">本次作业是图片，点我下载</a>
                <?php endif;?>
            </header>
            <form method="post" action="<?= $url?>">
                <div id="java-homework-md">
                    <textarea style="display:none;"><?php echo $model->content_md;?></textarea>
                </div>

                <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>" />

                <div style="width:90%;margin: 10px auto;">
                    <input type="submit" name="submit" value="我已完成！" style="padding: 5px;" />
                </div>
            </form>
        </div>
        <script src="/editor.md/js/jquery.min.js"></script>
        <script src="/editor.md/js/editormd.js"></script>
        <script type="text/javascript">
            $(function() {
                $.get("/editor.md/tips.md", function(md) {
                    var editor = editormd("java-homework-md", {
                        width  : "90%",
                        height : 640,
                        path   : "/editor.md/lib/",
                        <?php if ($model->getIsNewRecord()) {
                            echo 'appendMarkdown : md,';
                        }?>
                        saveHTMLToTextarea : true,
                        htmlDecode: true,
                    });
                });

                //editor.getMarkdown();       // 获取 Markdown 源码
                //editor.getHTML();           // 获取 Textarea 保存的 HTML 源码
                //editor.getPreviewedHTML();  // 获取预览窗口里的 HTML，在开启 watch 且没有开启 saveHTMLToTextarea 时使用
            });
        </script>
    </body>
</html>
