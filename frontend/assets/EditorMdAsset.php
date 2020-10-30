<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * editor.md 资源包
 */
class EditorMdAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'editor.md/css/style.css',
        'editor.md/css/editormd.css',
    ];
    public $js = [
        //'editor.md/js/jquery.min.js',
        'editor.md/js/editormd.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
