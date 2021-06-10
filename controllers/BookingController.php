<?php

namespace app\controllers;

use Yii;

class BookingController extends \app\controllers\CController {

    private $moduleName = "Booking";

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'search', 'search-result'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actionIndex() {
        Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        return $this->render('index');
    }

    public function actionSearch() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Search by " . $this->moduleName . " ID";
        return $this->render('search');
    }

    public function actionSearchResult() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Result for {BOOKINGID}";
        return $this->render('search-result');
    }

}
