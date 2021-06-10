<?php

namespace app\controllers;

class TrackController extends CController {

    private $moduleName = "";

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Track Cab or Driver & Booking";
        return $this->render('track');
    }

    public function actionTrackResult() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Track Result";
        return $this->render('track-result');
    }

}
