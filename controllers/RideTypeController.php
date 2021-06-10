<?php

namespace app\controllers;

use Yii;

class RideTypeController extends CController {

    private $moduleName = "Ride Type";

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'edit'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        $searchModel = new \app\models\RideTypeSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 1;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEdit($id) {
        $model = $this->findModel($id);
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit - " . $this->moduleName;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
                    'model' => $model,
        ]);
    }

    protected function findModel($id) {
        if (($model = \app\models\RideTypeMaster::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
