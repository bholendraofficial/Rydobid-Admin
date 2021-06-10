<?php

namespace app\controllers;

class ContentManageController extends CController {

    private $moduleName = "Content management";

    public function actionAboutUs() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "About Us - " . $this->moduleName;
        $model = \app\models\CmAboutusMaster::findOne(1);
        $model->scenario = 'update';
        $OldFile = $model->ryb_cm_aboutus_file;
        if ($model->load(\Yii::$app->request->post())) {
            $model->ryb_cm_aboutus_file = \yii\web\UploadedFile::getInstance($model, 'ryb_cm_aboutus_file');
            if ($model->ryb_cm_aboutus_file) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_cm_aboutus_file->extension;
                $model->setAttribute("ryb_cm_aboutus_file", $this->uploadUserFileAPI($model->ryb_cm_aboutus_file, $FileName));
            } else {
                $model->setAttribute("ryb_cm_aboutus_file", $OldFile);
            }
            if ($model->save()) {
                return $this->redirect(["content-manage/about-us"]);
            }
        }
        return $this->render('about-us', [
                    'model' => $model
        ]);
    }

    public function actionTermsConditions() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Terms & Conditions - " . $this->moduleName;
        $model = \app\models\CmTermConditionMaster::findOne(1);
        $model->scenario = 'update';
        $OldFile = $model->ryb_cm_term_condition_file;
        if ($model->load(\Yii::$app->request->post())) {
            $model->ryb_cm_term_condition_file = \yii\web\UploadedFile::getInstance($model, 'ryb_cm_term_condition_file');
            if ($model->ryb_cm_term_condition_file) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_cm_term_condition_file->extension;
                $model->setAttribute("ryb_cm_term_condition_file", $this->uploadUserFileAPI($model->ryb_cm_term_condition_file, $FileName));
            } else {
                $model->setAttribute("ryb_cm_term_condition_file", $OldFile);
            }
            if ($model->save()) {
                return $this->redirect(["content-manage/terms-conditions"]);
            }
        }
        return $this->render('terms-conditions', [
                    'model' => $model
        ]);
    }

    public function actionPrivacyPolicy() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Privacy Policy - " . $this->moduleName;
        $model = \app\models\CmPrivacyPolicyMaster::findOne(1);
        $model->scenario = 'update';
        $OldFile = $model->ryb_cm_privacy_policy_file;
        if ($model->load(\Yii::$app->request->post())) {
            $model->ryb_cm_privacy_policy_file = \yii\web\UploadedFile::getInstance($model, 'ryb_cm_privacy_policy_file');
            if ($model->ryb_cm_privacy_policy_file) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_cm_privacy_policy_file->extension;
                $model->setAttribute("ryb_cm_privacy_policy_file", $this->uploadUserFileAPI($model->ryb_cm_privacy_policy_file, $FileName));
            } else {
                $model->setAttribute("ryb_cm_privacy_policy_file", $OldFile);
            }
            if ($model->save()) {
                return $this->redirect(["content-manage/privacy-policy"]);
            }
        }
        return $this->render('privacy-policy', [
                    'model' => $model
        ]);
    }

    public function actionCancelRefundPolicy() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Cancellation & Refund Policy - " . $this->moduleName;
        $model = \app\models\CmCancelRefundMaster::findOne(1);
        $model->scenario = 'update';
        $OldFile = $model->ryb_cm_cancel_refund_file;
        if ($model->load(\Yii::$app->request->post())) {
            $model->ryb_cm_cancel_refund_file = \yii\web\UploadedFile::getInstance($model, 'ryb_cm_cancel_refund_file');
            if ($model->ryb_cm_cancel_refund_file) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_cm_cancel_refund_file->extension;
                $model->setAttribute("ryb_cm_cancel_refund_file", $this->uploadUserFileAPI($model->ryb_cm_cancel_refund_file, $FileName));
            } else {
                $model->setAttribute("ryb_cm_cancel_refund_file", $OldFile);
            }
            if ($model->save()) {
                return $this->redirect(["content-manage/cancel-refund-policy"]);
            }
        }
        return $this->render('cancel-refund-policy', [
                    'model' => $model
        ]);
    }

}
