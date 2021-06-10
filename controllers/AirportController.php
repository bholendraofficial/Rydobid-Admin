<?php

namespace app\controllers;

use Yii;

class AirportController extends CController {

    private $moduleName = "Airport";

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
        $searchModel = new \app\models\AirportSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 1;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Add - " . $this->moduleName;
        $model = new \app\models\AirportMaster();
        $airportCityModel = new \app\models\AirportCityMaster();
        $countryArray = \yii\helpers\ArrayHelper::map(\app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_country_id', 'ryb_country_title');
        if ($model->load(Yii::$app->request->post()) && $airportCityModel->load(Yii::$app->request->post())) {
            if ($model->save()) {
                foreach ($airportCityModel->ryb_city_id as $key => $value) {
                    $air_CityModel = new \app\models\AirportCityMaster();
                    $air_CityModel->load(Yii::$app->request->post());
                    $air_CityModel->setAttribute("ryb_city_id", $value);
                    $air_CityModel->setAttribute("ryb_airport_id", $model->ryb_airport_id);
                    $air_CityModel->save();
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('_form', [
                    'model' => $model,
                    'airportCityModel' => $airportCityModel,
                    'countryArray' => $countryArray
        ]);
    }

    public function actionEdit($id) {
        $model = $this->findModel($id);
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit - {$model->ryb_airport_name} - " . $this->moduleName;
        $airportCityModel = \app\models\AirportCityMaster::find()->where(["ryb_airport_id" => $model->ryb_airport_id])->one();
        $countryArray = \yii\helpers\ArrayHelper::map(\app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_country_id', 'ryb_country_title');
        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['index']);
        }
        return $this->render('_form', [
                    'model' => $model,
                    'airportCityModel' => $airportCityModel,
                    'countryArray' => $countryArray
        ]);
    }

    /* public function actionToggleStatus($id) {

      } */

    protected function findModel($id) {
        if (($model = \app\models\AirportMaster::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
