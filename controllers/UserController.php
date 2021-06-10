<?php

namespace app\controllers;

use Yii;

class UserController extends CController {

    private $moduleName = "User";

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        $searchModel = new \app\models\UserSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Register " . $this->moduleName;
        $model = new \app\models\UserMaster(['scenario' => 'web_register']);
        if ($model->load(\Yii::$app->request->post())) {
            $model->setAttribute("ryb_user_login_method", 1);
            $model->ryb_user_picture = \yii\web\UploadedFile::getInstance($model, 'ryb_user_picture');
            $FileName = uniqid("IMG_", true) . "." . $model->ryb_user_picture->extension;
            $model->setAttribute("ryb_user_picture", $this->uploadUserFileAPI($model->ryb_user_picture, $FileName));
            $model->setAttribute("ryb_user_password", Yii::$app->getSecurity()->generatePasswordHash($model->ryb_user_password));
            if ($model->save()) {
                return $this->redirect(["user/index"]);
            }
        }
        return $this->render('_form', [
                    'model' => $model
        ]);
    }

    public function actionEdit($id) {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit - " . $this->moduleName;
        $model = \app\models\UserMaster::findOne($id);
        $model->scenario = 'web_update';
        $OldPassword = $model->ryb_user_password;
        $OldUploadedFile = $model->ryb_user_picture;
        $model->ryb_user_password = '';
        if ($model->load(\Yii::$app->request->post())) {
            $model->setAttribute("ryb_user_login_method", 1);
            $model->ryb_user_picture = \yii\web\UploadedFile::getInstance($model, 'ryb_user_picture');
            if (Yii::$app->request->post('UserMaster')['ryb_user_password'] != "") {
                $model->setAttribute("ryb_user_password", Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->request->post('UserMaster')['ryb_user_password']));
            } else {
                $model->setAttribute("ryb_user_password", $OldPassword);
            }
            if ($model->ryb_user_picture) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_user_picture->extension;
                $model->setAttribute("ryb_user_picture", $this->uploadUserFileAPI($model->ryb_user_picture, $FileName));
            } else {
                $model->setAttribute("ryb_user_picture", $OldUploadedFile);
            }
            if ($model->save()) {
                return $this->redirect(["user/index"]);
            }
        }
        return $this->render('_form', [
                    'model' => $model
        ]);
    }

    public function actionSearch() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Search by " . $this->moduleName . " ID";
        return $this->render('search');
    }

    public function actionSearchResult($id) {
        $User = \app\models\UserMaster::find()->where(["ryb_user_id" => $id])->joinWith(["rybStatus"])->one();
        \Yii::$app->params["page_meta_data"]["page_title"] = "Result for " . $User->ryb_user_fullname;
        return $this->render('search-result', [
                    'model' => $User
        ]);
    }

}
