<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;

class SiteController extends CController {

    public function beforeAction($action) {
        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'logout', 'error'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex() {
        Yii::$app->params["page_meta_data"]["page_title"] = "Dashboard";
        return $this->render('index');
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = "loginmain";
        Yii::$app->params["page_meta_data"]["page_title"] = "Sign In";
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(["site/verify"]);
        }
        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionVerify() {
        $this->layout = "loginmain";
        Yii::$app->params["page_meta_data"]["page_title"] = "Verify(2FA)";
        if (Yii::$app->request->post()) {
            return $this->redirect(["site/index"]);
        }
        return $this->render('verify');
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}
