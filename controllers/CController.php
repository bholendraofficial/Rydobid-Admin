<?php

namespace app\controllers;

use Yii;

class CController extends \yii\web\Controller {

    public $layout = "adminmain";

    public function beforeAction($action) {
        return parent::beforeAction($action);
    }

    protected function uploadFile($FileObject, $FileName) {
        if (!file_exists(Yii::$app->basePath . '/web/uploads/admin-images/')) {
            mkdir(Yii::$app->basePath . '/web/uploads/admin-images/', 0777, true);
        }
        $FileObject->saveAs(Yii::$app->basePath . '/web/uploads/admin-images/' . $FileName);
        return Yii::$app->request->baseUrl . '/uploads/admin-images/' . $FileName;
    }

    protected function uploadUserFileAPI($FileObject, $FileName) {
        if (!file_exists(Yii::$app->basePath . '/web/uploads/user-images/')) {
            mkdir(Yii::$app->basePath . '/web/uploads/user-images/', 0777, true);
        }
        $FileObject->saveAs(Yii::$app->basePath . '/web/uploads/user-images/' . $FileName);
        return Yii::$app->request->hostInfo . Yii::$app->request->baseUrl . '/uploads/user-images/' . $FileName;
    }

    protected function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtoupper($randomString);
    }

}
