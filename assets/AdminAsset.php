<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web/themes/assets/';
    public $css = [
        'css/app.min.css',
            #'vendors/bootstrap-datepicker/bootstrap-datepicker.min.css',
            #'vendors/datatables/dataTables.bootstrap.min.css',
            #'vendors/select2/select2.css',
    ];
    public $js = [
        'js/vendors.min.js',
        #'vendors/bootstrap-datepicker/bootstrap-datepicker.min.js',
        #'vendors/datatables/jquery.dataTables.min.js',
        #'vendors/datatables/dataTables.bootstrap.min.js',
        #'vendors/quill/quill.min.js',
        #'vendors/select2/select2.min.js',
        'js/app.min.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];

}
