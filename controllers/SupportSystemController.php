<?php

namespace app\controllers;

class SupportSystemController extends CController {

    private $moduleName = "Support System";

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage - Tickets | " . $this->moduleName;
        return $this->render('tickets');
    }

    public function actionSearch() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Search By Ticket ID | " . $this->moduleName;
        return $this->render('search');
    }

    public function actionTicketView() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "View Ticket - {TICKET_NAME} | " . $this->moduleName;
        return $this->render('ticket-view');
    }

    public function actionFaq() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage - FAQ | " . $this->moduleName;
        $model = new \app\models\CmFaqMaster();
        $FAQArray = \app\models\CmFaqMaster::find()->where(["ryb_status_id" => 2])->asArray()->all();
        if (\Yii::$app->request->get('QuestionId')) {
            \app\models\CmFaqMaster::deleteAll("ryb_cm_faq_id = " . \Yii::$app->request->get('QuestionId'));
            echo 1;
            exit;
        }
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(["support-system/faq"]);
        }
        return $this->render('faq', [
                    'model' => $model,
                    'FAQArray' => $FAQArray
        ]);
    }

}
