<?php

namespace app\controllers;

class PaymentController extends CController {

    private $moduleName = "Payment & Transaction";

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        return $this->render('index');
    }

    public function actionPaymentCredit() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Credit user wallet | " . $this->moduleName;
        return $this->render('payment-credit');
    }
    
    public function actionSettlement() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage all settlements |";
        return $this->render('settlement');
    }

    public function actionSearch() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Search by Transaction ID |" . $this->moduleName;
        return $this->render('search');
    }

    public function actionPaymentView() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "View transactions | " . $this->moduleName;
        return $this->render('payment-view');
    }

}
