<?php

namespace app\controllers;

use Yii;

class PromoCodeController extends CController {

    private $moduleName = "Promo code";

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'add', 'toggle-status', 'view'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function actionIndex() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        $searchModel = new \app\models\PromocodeSearchMaster();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Add - " . $this->moduleName;
        $model = new \app\models\PromocodeMaster(['scenario' => 'create']);
        $cityModel = new \app\models\PromocodeCityMaster();
        $cabTypeModel = new \app\models\PromocodeCabTypeMaster();
        $rideTypeModel = new \app\models\PromocodeRideTypeMaster();
        $countryArray = \yii\helpers\ArrayHelper::map(\app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_country_id', 'ryb_country_title');
        $cabTypeArray = \yii\helpers\ArrayHelper::map(\app\models\CabtypeMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_cabtype_id', 'ryb_cabtype_title');
        $rideTypeArray = \yii\helpers\ArrayHelper::map(\app\models\RideTypeMaster::find()->asArray()->all(), 'ryb_ride_type_id', 'ryb_ride_type_title');
        if (\Yii::$app->request->post('PromocodeMaster')) {
            $model->load(\Yii::$app->request->post());
            $model->setAttribute("ryb_promocode_is_ride_type", false);
            $model->setAttribute("ryb_promocode_is_cab_type", false);
            $model->setAttribute("ryb_promocode_is_city_type", false);
            if ($model->save()) {
                $PromocodeId = $model->ryb_promocode_id;
                if (\Yii::$app->request->post('PromocodeRideTypeMaster')['ryb_ride_type_id']) {
                    $model->setAttribute("ryb_promocode_is_ride_type", true);
                    foreach (\Yii::$app->request->post('PromocodeRideTypeMaster')['ryb_ride_type_id'] as $RideType) {
                        $rideTypeModel = new \app\models\PromocodeRideTypeMaster();
                        $rideTypeModel->setAttribute("ryb_ride_type_id", $RideType);
                        $rideTypeModel->setAttribute("ryb_promocode_id", $PromocodeId);
                        $rideTypeModel->save();
                    }
                }
                if (\Yii::$app->request->post('PromocodeCabTypeMaster')['ryb_cabtype_id']) {
                    $model->setAttribute("ryb_promocode_is_cab_type", true);
                    foreach (\Yii::$app->request->post('PromocodeCabTypeMaster')['ryb_cabtype_id'] as $CabType) {
                        $cabTypeModel = new \app\models\PromocodeCabTypeMaster();
                        $cabTypeModel->setAttribute("ryb_cabtype_id", $CabType);
                        $cabTypeModel->setAttribute("ryb_promocode_id", $PromocodeId);
                        $cabTypeModel->save();
                    }
                }
                if (\Yii::$app->request->post('PromocodeCityMaster')['ryb_city_id']) {
                    $model->setAttribute("ryb_promocode_is_city_type", true);
                    foreach (\Yii::$app->request->post('PromocodeCityMaster')['ryb_city_id'] as $City) {
                        $cityModel = new \app\models\PromocodeCityMaster();
                        $cityModel->setAttribute("ryb_city_id", $City);
                        $cityModel->setAttribute("ryb_promocode_id", $PromocodeId);
                        $cityModel->save();
                    }
                }
                if ($model->save()) {
                    return $this->redirect(["/promo-code/index"]);
                }
            }
        }
        return $this->render('_form', [
                    'model' => $model,
                    'countryArray' => $countryArray,
                    'cabTypeArray' => $cabTypeArray,
                    'rideTypeArray' => $rideTypeArray,
                    'cityModel' => $cityModel,
                    'cabTypeModel' => $cabTypeModel,
                    'rideTypeModel' => $rideTypeModel,
        ]);
    }

    public function actionView() {
        if (($model = \app\models\PromocodeMaster::find()
                ->where([
                    "ryb_promocode_master.ryb_promocode_id" => Yii::$app->request->get('id')
                ])
                ->joinWith(["promocodeCabTypeMasters", "promocodeCityMasters", "promocodeRideTypeMasters", "rybStatus"])
                ->one()) !== null) {
            \Yii::$app->params["page_meta_data"]["page_title"] = "View - " . $model->ryb_promocode_unique . " | " . $this->moduleName;
            return $this->render('view', ['model' => $model]);
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = \app\models\PromocodeMaster::findOne($id)) !== null) {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
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
