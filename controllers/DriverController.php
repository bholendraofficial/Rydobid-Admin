<?php

namespace app\controllers;

use app\models\DriverCabMaster;
use app\models\DriverCabStatusMaster;
use app\models\DriverMaster;
use app\models\DriverSearchMaster;
use app\models\UserMaster;
use app\models\UserSearchMaster;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class DriverController extends CController
{

    private $moduleName = "Driver";

    public function actionIndex()
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage " . $this->moduleName;
        $searchModel = new UserSearchMaster();
        $dataProvider = $searchModel->search_driver(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $Driver = UserMaster::find()->where(['ryb_user_master.ryb_user_id' => $id])->joinWith([
            'rybDriver', 'rybDriver.driverCab', 'rybDriver.driverCab.rybDriverCabStatus'
        ])->one();
        if (!$Driver) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        \Yii::$app->params["page_meta_data"]["page_heading"] = \Yii::$app->params["page_meta_data"]["page_title"] = "View - " . $Driver->ryb_user_fullname . " | RydoBid";
        return $this->render('view', [
            'Driver' => $Driver
        ]);
    }

    public function actionKyc($id)
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Driver - KYC";
        $DriverCab = DriverMaster::find()->where(['ryb_user_id' => $id])->joinWith([
            'driverCab', 'driverCab.rybDriverCabStatus'
        ])->one();
        if (is_null($DriverCab->driverCab)) {
            throw new BadRequestHttpException('Error: KYC or Cab missing');
        }
        if (\Yii::$app->request->post()) {
            $DriverCab->driverCab->load(\Yii::$app->request->post());
            $DriverCab->driverCab->save();
            return $this->redirect(['driver/view', 'id' => $id]);
        }
        return $this->render('kyc', [
            'DriverCab' => $DriverCab,
            'DriverCabModel' => $DriverCab->driverCab,
            'KYCStatusArray' => ArrayHelper::map(DriverCabStatusMaster::find()->all(), 'ryb_driver_cab_status_id', 'ryb_driver_cab_status_text')
        ]);
    }

    public function actionAdd()
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Register " . $this->moduleName . " with RydoBid";
        return $this->render('_form');
    }

    public function actionEdit()
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Edit - " . $this->moduleName;
        return $this->render('_form');
    }

    public function actionSearch()
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Search by " . $this->moduleName . " ID";
        return $this->render('search');
    }

    public function actionSearchResult()
    {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Result for {DRIVERNAME}";
        return $this->render('search-result');
    }

}
