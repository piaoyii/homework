<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * HtmlPreviewMarkdownToHtmlAsset 资源包
 */
class HtmlPreviewMarkdownToHtmlAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'editor.md/css/style.css',
        'editor.md/css/editormd.preview.css',
    ];
    public $js = [
        'editor.md/lib/prettify.min.js',
        'editor.md/lib/raphael.min.js',
        'editor.md/lib/underscore.min.js',
        'editor.md/lib/sequence-diagram.min.js',
        'editor.md/lib/flowchart.min.js',
        'editor.md/lib/jquery.flowchart.min.js',
        'editor.md/js/editormd.js',
        'editor.md/lib/marked.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
