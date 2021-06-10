<?php

namespace app\controllers;

use Yii;

class CabTypeController extends CController {

    private $moduleName = "Cab Type";

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'add', 'edit', 'toggle-status'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        $searchModel = new \app\models\CabtypeSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 1;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Add - " . $this->moduleName;
        $model = new \app\models\CabtypeMaster(['scenario' => 'create']);
        if ($model->load(Yii::$app->request->post())) {
            $model->ryb_cabtype_icon = (\yii\web\UploadedFile::getInstance($model, 'ryb_cabtype_icon'));
            $FileName = uniqid("IMG_", true) . "." . $model->ryb_cabtype_icon->extension;
            $model->setAttribute("ryb_cabtype_icon", $this->uploadFile($model->ryb_cabtype_icon, $FileName));
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    public function actionEdit($id) {
        $model = $this->findModel($id);
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit - " . $this->moduleName;
        $UploadedOldImage = $model->ryb_cabtype_icon;
        if ($model->load(Yii::$app->request->post())) {
            $model->ryb_cabtype_icon = (\yii\web\UploadedFile::getInstance($model, 'ryb_cabtype_icon'));
            if (!is_null($model->ryb_cabtype_icon)) {
                $FileName = uniqid("IMG_", true) . "." . $model->ryb_cabtype_icon->extension;
                $model->setAttribute("ryb_cabtype_icon", $this->uploadFile($model->ryb_cabtype_icon, $FileName));
            } else {
                $model->setAttribute("ryb_cabtype_icon", $UploadedOldImage);
            }
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    protected function findModel($id) {
        if (($model = \app\models\CabtypeMaster::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionToggleStatus() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel(\Yii::$app->request->post('id'));
        $model->setAttribute("ryb_status_id", \Yii::$app->request->post('status'));
        if ($model->save()) {
            return json_encode([
                "status" => 1,
                "message" => '<div class="toast fade hide" data-delay="3000">
        <div class="toast-header"><i class="anticon anticon-info-circle text-primary m-r-5"></i><strong class="mr-auto">Alert!</strong><small>Just now</small></div>
        <div class="toast-body">We have just updated status!</div>
    </div>'
            ]);
        } else {
            return json_encode([
                "status" => 0,
                "message" => '<div class="toast fade hide" data-delay="3000">
        <div class="toast-header"><i class="anticon anticon-info-circle text-primary m-r-5"></i><strong class="mr-auto">Alert!</strong><small>Just now</small></div>
        <div class="toast-body">Error, something does\'t look good!</div>
    </div>'
            ]);
        }
        \Yii::$app->end();
    }

}
