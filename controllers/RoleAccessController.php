<?php

namespace app\controllers;

class RoleAccessController extends CController {

    private $moduleName = "";

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage Roles " . $this->moduleName;
        return $this->render('index');
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Add Role & Set Access " . $this->moduleName;
        return $this->render('_form');
    }

}
