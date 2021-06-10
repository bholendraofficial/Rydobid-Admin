<?php

namespace app\controllers;

class AdminController extends CController {

    private $moduleName = "Admin";

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'add', 'edit'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        return $this->render('index');
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Add " . $this->moduleName;
        return $this->render('_form');
    }

    public function actionEdit() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit " . $this->moduleName;
        return $this->render('_form');
    }

}
