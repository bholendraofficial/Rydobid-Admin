<?php

namespace app\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/assets/';
    public $css = [
        'css/app.min.css'
    ];
    public $js = [
        'js/vendors.min.js',
        'js/app.min.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

}
