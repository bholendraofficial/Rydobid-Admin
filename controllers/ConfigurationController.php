<?php

namespace app\controllers;

use Yii;

class ConfigurationController extends CController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => [
                    'countries', 'states', 'cities', 'pincodes', 'config-params', 'config-common', 'toggle-status',
                    'fetch-states', 'fetch-cities', 'fetch-pincodes', 'filter-fetch-states,', 'filter-fetch-cities',
                    'pincode-import'
                ],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ]
        ];
    }

    public function beforeAction($action) {
        if (in_array($action->id, ["fetch-states", "filter-fetch-states", "fetch-cities", "filter-fetch-cities", "fetch-pincodes"])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionCountries() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage Countries";
        $searchModel = new \app\models\CountrySearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $formModel = new \app\models\CountryMaster();
        if (\Yii::$app->request->get('id')) {
            $formModel = \app\models\CountryMaster::findOne((int) \Yii::$app->request->get('id'));
        }
        if (!$formModel) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        if ($formModel->load(Yii::$app->request->post())) {
            $formModel->setAttribute("ryb_country_title", ucwords($formModel->ryb_country_title));
            if ($formModel->save()) {
                return $this->redirect(['countries']);
            }
        }
        return $this->render('countries', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'formModel' => $formModel
        ]);
    }

    public function actionStates() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage States";
        $searchModel = new \app\models\StateSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $formModel = new \app\models\StateMaster();
        if (\Yii::$app->request->get('id')) {
            $formModel = \app\models\StateMaster::findOne((int) \Yii::$app->request->get('id'));
        }
        if (!$formModel) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        if ($formModel->load(Yii::$app->request->post())) {
            $formModel->setAttribute("ryb_state_title", ucwords($formModel->ryb_state_title));
            if ($formModel->save()) {
                return $this->redirect(['states']);
            }
        }
        return $this->render('states', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'formModel' => $formModel,
                    'countryArray' => \yii\helpers\ArrayHelper::map(
                            \app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(),
                            'ryb_country_id', 'ryb_country_title')
        ]);
    }

    public function actionCities() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage Cities";
        $searchModel = new \app\models\CitySearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $formModel = new \app\models\CityMaster();
        if (\Yii::$app->request->get('id')) {
            $formModel = \app\models\CityMaster::findOne((int) \Yii::$app->request->get('id'));
        }
        if (!$formModel) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        if ($formModel->load(Yii::$app->request->post())) {
            $formModel->setAttribute("ryb_city_title", ucwords($formModel->ryb_city_title));
            if ($formModel->save()) {
                return $this->redirect(['cities']);
            }
        }
        return $this->render('cities', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'formModel' => $formModel,
                    'countryArray' => \yii\helpers\ArrayHelper::map(
                            \app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(),
                            'ryb_country_id', 'ryb_country_title'),
                    'statesArray' => []
        ]);
    }

    public function actionPincodes() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Manage Pincodes";
        $searchModel = new \app\models\PincodeSearchMaster();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $formModel = new \app\models\PincodeMaster();
        if (\Yii::$app->request->get('id')) {
            $formModel = \app\models\PincodeMaster::findOne((int) \Yii::$app->request->get('id'));
        }
        if (!$formModel) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
        if ($formModel->load(Yii::$app->request->post()) && $formModel->save()) {
            return $this->redirect(['pincodes']);
        }
        return $this->render('pincode', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'formModel' => $formModel,
                    'countryArray' => \yii\helpers\ArrayHelper::map(
                            \app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(),
                            'ryb_country_id', 'ryb_country_title'),
                    'statesArray' => [],
                    'citiesArray' => [],
                    'importPincodeModel' => new \app\models\PincodeMaster(['scenario' => 'import']),
        ]);
    }

    public function actionPincodeImport() {
        if (\Yii::$app->request->post()) {
            $UploadedFile = \yii\web\UploadedFile::getInstance(new \app\models\PincodeMaster(['scenario' => 'import']), 'ryb_csv_file');
            $csvArrayData = [];
            if (($handle = fopen($UploadedFile->tempName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $csvArrayData[] = $data;
                }
                fclose($handle);
            }
            array_shift($csvArrayData);
            $GroupedValues = [];
            foreach ($csvArrayData as $Pincode) {
                if (array_key_exists($Pincode[1], $GroupedValues)) {
                    $GroupedValues[$Pincode[1]] = $GroupedValues[$Pincode[1]] . ", " . $Pincode[0];
                } else {
                    $GroupedValues[$Pincode[1]] = $Pincode[0];
                }
            }
            foreach ($GroupedValues as $key => $value) {
                $PincodeModel = \app\models\PincodeMaster::find()->where(["ryb_pincode_number" => $key])->one();
                if (!$PincodeModel) {
                    $PincodeModel = new \app\models\PincodeMaster();
                }
                $PincodeModel->load(\Yii::$app->request->post());
                $PincodeModel->setAttribute("ryb_pincode_number", $key);
                $PincodeModel->setAttribute("ryb_pincode_title", $value);
                $PincodeModel->save();
            }
            return $this->redirect(["configuration/pincodes"]);
        }
    }

    public function actionToggleStatus() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        switch ((string) \Yii::$app->request->post('type')) {
            case "countries":
                $model = \app\models\CountryMaster::findOne((int) \Yii::$app->request->post('id'));
                break;
            case "states":
                $model = \app\models\StateMaster::findOne((int) \Yii::$app->request->post('id'));
                break;
            case "cities":
                $model = \app\models\CityMaster::findOne((int) \Yii::$app->request->post('id'));
                break;
            case "pincodes":
                $model = \app\models\PincodeMaster::findOne((int) \Yii::$app->request->post('id'));
                break;
        }
        if (!$model) {
            return json_encode([
                "status" => 0,
                "message" => '<div class="toast fade hide" data-delay="3000">
        <div class="toast-header"><i class="anticon anticon-info-circle text-primary m-r-5"></i><strong class="mr-auto">Alert!</strong><small>Just now</small></div>
        <div class="toast-body">Oops, Invalid request!</div>
    </div>'
            ]);
        } else {
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
        }
        exit;
        \Yii::$app->end();
    }

    public function actionFetchStates() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (count($parents) > 0 && $parents[0] != "") {
                return ['output' => \app\models\StateMaster::find()->select(["ryb_state_id AS id", "ryb_state_title AS name"])->where([
                                "ryb_country_id" => $parents[0], "ryb_status_id" => 2])
                            ->asArray()->all(), 'selected' => $_POST['depdrop_all_params']['selected_state_id']];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFilterFetchStates() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (count($parents) > 0 && $parents[0] != "") {
                return ['output' => \app\models\StateMaster::find()->select(["ryb_state_id AS id", "ryb_state_title AS name"])->where([
                                "ryb_country_id" => $parents[0], "ryb_status_id" => 2])
                            ->asArray()->all(), 'selected' => $_POST['depdrop_all_params']['flselected_state_id']];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFetchCities() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (count($parents) > 0 && $parents[0] != "") {
                return ['output' => \app\models\CityMaster::find()->select(["ryb_city_id AS id", "ryb_city_title AS name"])->where([
                                "ryb_state_id" => $parents[0], "ryb_status_id" => 2])
                            ->asArray()->all(), 'selected' => $_POST['depdrop_all_params']['selected_city_id']];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFilterFetchCities() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (count($parents) > 0 && $parents[0] != "") {
                return ['output' => \app\models\CityMaster::find()->select(["ryb_city_id AS id", "ryb_city_title AS name"])->where([
                                "ryb_state_id" => $parents[0], "ryb_status_id" => 2])
                            ->asArray()->all(), 'selected' => $_POST['depdrop_all_params']['flselected_city_id']];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionFetchPincodes() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (count($parents) > 0 && $parents[0] != "") {
                $PincodesArray = [];
                foreach (\app\models\PincodeMaster::find()->where([
                            "ryb_city_id" => $parents[0], "ryb_status_id" => 2])
                        ->asArray()->all() as $value) {
                    $PincodesArray[] = [
                        "id" => $value["ryb_pincode_id"],
                        "name" => $value["ryb_pincode_title"] . " - " . $value["ryb_pincode_number"]
                    ];
                }
                return ['output' => $PincodesArray, 'selected' => $_POST['depdrop_all_params']['selected_pincode_id']];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionConfigParams() {
        ini_set('memory_limit', '-1');
        \Yii::$app->params["page_meta_data"]["page_title"] = "Configure Parameters";
        $CabTypeArray = \yii\helpers\ArrayHelper::map(\app\models\CabtypeMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_cabtype_id', 'ryb_cabtype_title');
        $RideTypeArray = \yii\helpers\ArrayHelper::map(\app\models\RideTypeMaster::find()->asArray()->all(), 'ryb_ride_type_id', 'ryb_ride_type_title');
        $CountryArray = \yii\helpers\ArrayHelper::map(\app\models\CountryMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_country_id', 'ryb_country_title');
        $TimeSlotArray = \app\models\TimeSlotMaster::find()->asArray()->all();
        $SelectedPincode = [];
        $SelectedCity = [];
        $SelectedState = [];
        $SelectedCountry = [];
        $FormUrl = \yii\helpers\Url::to(["/configuration/config-params"]);
        if (\Yii::$app->request->get('PincodeId')) {
            $FormUrl = \yii\helpers\Url::to(["/configuration/config-params", "PincodeId" => \Yii::$app->request->get('PincodeId')]);
            $Pincode = \app\models\PincodeMaster::find()
                            ->where(["ryb_pincode_id" => \Yii::$app->request->get('PincodeId')])
                            ->joinWith(["rybState", "rybCity", "rybCountry"])->asArray()->one();
            $SelectedPincode [$Pincode["ryb_pincode_id"]] = $Pincode["ryb_pincode_title"] . "-" . $Pincode["ryb_pincode_number"];
            $SelectedCity [$Pincode["rybCity"]["ryb_city_id"]] = $Pincode["rybCity"]["ryb_city_title"];
            $SelectedState = $Pincode["rybState"]["ryb_state_id"];
            $SelectedCountry = $Pincode["rybCountry"]["ryb_country_id"];
        }

        if (\Yii::$app->request->get('CityId')) {
            $FormUrl = \yii\helpers\Url::to(["/configuration/config-params", "CityId" => \Yii::$app->request->get('CityId')]);
            $City = \app\models\CityMaster::find()
                            ->where(["ryb_city_master.ryb_city_id" => \Yii::$app->request->get('CityId')])
                            ->joinWith(["rybState", "rybCountry", "pincodeMasters"])->asArray()->one();
            $SelectedCountry = $City["rybCountry"]["ryb_country_id"];
            $SelectedCity [$City["ryb_city_id"]] = ["rybCity"]["ryb_city_title"];
            $SelectedState = $City["rybState"]["ryb_state_id"];
            foreach ($City["pincodeMasters"] as $Pincode) {
                $SelectedPincode[$Pincode["ryb_pincode_id"]] = $Pincode["ryb_pincode_title"] . "-" . $Pincode["ryb_pincode_number"];
            }
        }

        if (\Yii::$app->request->get('StateId')) {
            $FormUrl = \yii\helpers\Url::to(["/configuration/config-params", "CityId" => \Yii::$app->request->get('StateId')]);
            $State = \app\models\StateMaster::find()
                            ->where(["ryb_state_master.ryb_state_id" => \Yii::$app->request->get('StateId')])
                            ->joinWith(["rybCountry", "cityMasters", "pincodeMasters"])->asArray()->one();
            $SelectedCountry = $State["rybCountry"]["ryb_country_id"];
            $SelectedState = $State["ryb_state_id"];
            foreach ($State["cityMasters"] as $City) {
                $SelectedCity[$City["ryb_city_id"]] = $City["ryb_city_title"];
            }
            foreach ($State["pincodeMasters"] as $Pincode) {
                $SelectedPincode[$Pincode["ryb_pincode_id"]] = $Pincode["ryb_pincode_title"] . "-" . $Pincode["ryb_pincode_number"];
            }
        }

        if (Yii::$app->request->post()) {
            /*
             * DELETE PREVIOUS AMOUNT
             */
            if (count($SelectedPincode) > 0) {
                /* echo "<pre>";
                  print_r($SelectedPincode);
                  print_r(Yii::$app->request->post('ryb_conf_package_master')["ryb_pincode_id"]);
                  exit;
                  foreach ($SelectedPincode as $Key => $Pincode) {
                  \app\models\ConfPackageMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\BidTimeMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\RentalRateCardMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\DriverRadiusMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\PenaltyAmntMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\BidamntPercentMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\CommPercentMaster::deleteAll("ryb_pincode_id = " . $Key);
                  \app\models\RateCardMaster::deleteAll("ryb_pincode_id = " . $Key);
                  } */
            }
            $ConfPackage = Yii::$app->request->post('ryb_conf_package_master');
            $CommPercent = Yii::$app->request->post('ryb_comm_percent_master');
            $BidAmountPercent = Yii::$app->request->post('ryb_bidamnt_percent_master');
            $PenaltyAmount = Yii::$app->request->post('ryb_penalty_amnt_master');
            $DriverRadius = Yii::$app->request->post('ryb_driver_radius_master');
            $RateCard = Yii::$app->request->post('ryb_rate_card_master');
            $RentalRateCard = Yii::$app->request->post('ryb_rental_rate_card_master');
            $BidTime = Yii::$app->request->post('ryb_bid_time_master');
            $ConfPackageIdArray = [];
            $InsertQueries = [];
            $InsertQueries["RateCardMaster"] = [];
            $InsertQueries["CommPercentMaster"] = [];
            $InsertQueries["BidamntPercentMaster"] = [];
            $InsertQueries["PenaltyAmntMaster"] = [];
            $InsertQueries["DriverRadiusMaster"] = [];
            $InsertQueries["BidTimeMaster"] = [];
            $InsertQueries["RentalRateCardMaster"] = [];
            foreach ($ConfPackage["ryb_pincode_id"] as $Pincode) {
                $PincodeData = \app\models\PincodeMaster::find()
                        ->select(["ryb_city_id", "ryb_state_id", "ryb_country_id", "ryb_pincode_id"])
                        ->where(["ryb_pincode_id" => $Pincode])
                        ->asArray()
                        ->one();

                /*
                 * DELETE PREVIOUS AMOUNT
                 */

                \app\models\ConfPackageMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\BidTimeMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\RentalRateCardMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\DriverRadiusMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\PenaltyAmntMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\BidamntPercentMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\CommPercentMaster::deleteAll("ryb_pincode_id = " . $Pincode);
                \app\models\RateCardMaster::deleteAll("ryb_pincode_id = " . $Pincode);

                /*
                 * CONFIGURATION PACKAGE
                 */
                $ConfPackageModel = new \app\models\ConfPackageMaster();

                $ConfPackageModel->setAttribute("ryb_conf_package_response_time", $ConfPackage["ryb_conf_package_response_time"]);
                $ConfPackageModel->setAttribute("ryb_conf_package_no_of_driver", $ConfPackage["ryb_conf_package_no_of_driver"]);
                $ConfPackageModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                $ConfPackageModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                $ConfPackageModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                $ConfPackageModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                $ConfPackageModel->save(false);

                $ConfPackageID = $ConfPackageModel->ryb_conf_package_id;
                $ConfPackageIdArray[] = $ConfPackageID;

                /*
                 * RATE CARD(DAILY, OUTSTATION, AIRPORT)
                 */

                foreach ($RateCard as $RateKey => $RateValue) {
                    foreach ($RateValue as $RK => $RV) {
                        foreach ($RV as $SLT_K => $SLT_V) {
                            /*
                              INSERT INTO ryb_rate_card_master
                              (ryb_rate_card_pr_km, ryb_time_slot_id, ryb_cabtype_id, ryb_ride_type_id,
                              ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                              values
                              (10,1,10,1,940,2868,25,17,6),
                              (11,2,10,1,940,2897,25,17,6),
                              (12,3,10,1,940,2868,25,17,6),
                              (13,4,10,1,940,2897,25,17,6);
                             */
                            $InsertQueries["RateCardMaster"][] = "({$SLT_V["ryb_rate_card_pr_km"]},{$SLT_K},{$RK},{$RateKey},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";
                            /* $RateCardModel = new \app\models\RateCardMaster();
                              $RateCardModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                              $RateCardModel->setAttribute("ryb_time_slot_id", $SLT_K);
                              $RateCardModel->setAttribute("ryb_rate_card_pr_km", $SLT_V["ryb_rate_card_pr_km"]);
                              $RateCardModel->setAttribute("ryb_ride_type_id", $RateKey);
                              $RateCardModel->setAttribute("ryb_cabtype_id", $RK);
                              $RateCardModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                              $RateCardModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                              $RateCardModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                              $RateCardModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                              $RateCardModel->save(false); */
                        }
                    }
                }

                /*
                 * COMMISSION PERCENTAGE 
                 */
                foreach ($CommPercent as $RideTypeId => $Commission) {
                    /*
                      INSERT INTO ryb_comm_percent_master
                      (ryb_comm_percent_amt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values
                      (20,1,940,2868,25,17,6),
                      (15,2,940,2897,25,17,6),
                      (10,3,940,2868,25,17,6),
                      (5,4,940,2897,25,17,6);
                     */
                    $InsertQueries["CommPercentMaster"][] = "({$Commission["ryb_comm_percent_amt"]},{$RideTypeId},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";

                    /* $CommPercentModel = new \app\models\CommPercentMaster();

                      $CommPercentModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                      $CommPercentModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $CommPercentModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $CommPercentModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $CommPercentModel->setAttribute("ryb_ride_type_id", $RideTypeId);
                      $CommPercentModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                      $CommPercentModel->setAttribute("ryb_comm_percent_amt", $Commission["ryb_comm_percent_amt"]);
                      $CommPercentModel->save(false); */
                }

                /*
                 * BID AMOUNT PERCENTAGE
                 */
                foreach ($BidAmountPercent as $RideTypeId => $BidAmount) {
                    /*
                      INSERT INTO ryb_bidamnt_percent_master
                      (ryb_bid_amnt_percent_amt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values
                      (10,1,940,2868,25,17,6),
                      (12,2,940,2897,25,17,6),
                      (15,3,940,2868,25,17,6),
                      (20,4,940,2897,25,17,6);
                     */

                    $InsertQueries["BidamntPercentMaster"][] = "({$BidAmount["ryb_bid_amnt_percent_amt"]},{$RideTypeId},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";
                    /* $BidAmountModel = new \app\models\BidamntPercentMaster();

                      $BidAmountModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                      $BidAmountModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $BidAmountModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $BidAmountModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $BidAmountModel->setAttribute("ryb_ride_type_id", $RideTypeId);
                      $BidAmountModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                      $BidAmountModel->setAttribute("ryb_bid_amnt_percent_amt", $BidAmount["ryb_bid_amnt_percent_amt"]);
                      $BidAmountModel->save(false); */
                }

                /*
                 * PENALTY AMOUNT
                 */
                foreach ($PenaltyAmount as $RideTypeId => $Penalty) {
                    /*
                      INSERT INTO ryb_penalty_amnt_master
                      (ryb_penalty_amnt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values
                      (100,1,940,2868,25,17,6),
                      (200,2,940,2897,25,17,6),
                      (300,3,940,2868,25,17,6),
                      (400,4,940,2897,25,17,6);
                     */

                    $InsertQueries["PenaltyAmntMaster"][] = "({$Penalty["ryb_penalty_amnt"]},{$RideTypeId},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";

                    /* $PenaltyAmountModel = new \app\models\PenaltyAmntMaster();

                      $PenaltyAmountModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                      $PenaltyAmountModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $PenaltyAmountModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $PenaltyAmountModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $PenaltyAmountModel->setAttribute("ryb_ride_type_id", $RideTypeId);
                      $PenaltyAmountModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                      $PenaltyAmountModel->setAttribute("ryb_penalty_amnt", $Penalty["ryb_penalty_amnt"]);
                      $PenaltyAmountModel->save(false); */
                }

                /*
                 * DRIVER RADIUS
                 */
                foreach ($DriverRadius as $RideTypeId => $Radius) {

                    /*
                      INSERT INTO ryb_driver_radius_master (ryb_driver_radius_metres, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id) values
                      (2250,1,940,2868,25,17,6),
                      (2000,2,940,2897,25,17,6),
                      (1750,3,940,2868,25,17,6),
                      (1500,4,940,2897,25,17,6);
                     */

                    $InsertQueries["DriverRadiusMaster"][] = "({$Radius["ryb_driver_radius_metres"]},{$RideTypeId},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";

                    /* $DriverRadiusModel = new \app\models\DriverRadiusMaster();

                      $DriverRadiusModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                      $DriverRadiusModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $DriverRadiusModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $DriverRadiusModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $DriverRadiusModel->setAttribute("ryb_ride_type_id", $RideTypeId);
                      $DriverRadiusModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                      $DriverRadiusModel->setAttribute("ryb_driver_radius_metres", $Radius["ryb_driver_radius_metres"]);
                      $DriverRadiusModel->save(false); */
                }

                /*
                 * RATE CARD(RENTAL)
                 */
                foreach ($RentalRateCard as $CabType => $RentalRate) {
                    /*
                      INSERT INTO ryb_rental_rate_card_master
                      (ryb_cabtype_id, ryb_ride_type_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id,
                      ryb_rental_rate_card_1hr, ryb_rental_rate_card_2hr, ryb_rental_rate_card_3hr, ryb_rental_rate_card_4hr,
                      ryb_rental_rate_card_5hr, ryb_rental_rate_card_6hr, ryb_rental_rate_card_7hr, ryb_rental_rate_card_8hr,
                      ryb_rental_rate_card_9hr, ryb_rental_rate_card_10hr, ryb_rental_rate_card_11hr, ryb_rental_rate_card_12hr)
                      values
                      (9,3,2868,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (10,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (11,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (12,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (13,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (14,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (15,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (16,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (17,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12),
                      (18,3,2897,25,17,6,1,2,3,4,5,6,7,8,9,10,11,12);

                     *  */
                    $Query = "({$CabType},3,{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]}";

                    foreach ($RentalRate as $HourKey => $HourValue) {
                        $Query .= ", {$HourValue}";
                    }
                    $Query .= ")";
                    $InsertQueries["RentalRateCardMaster"][] = $Query;

                    /* $RentalRateModel = new \app\models\RentalRateCardMaster();
                      $RentalRateModel->setAttribute("ryb_cabtype_id", $CabType);
                      $RentalRateModel->setAttribute("ryb_ride_type_id", 3);
                      $RentalRateModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $RentalRateModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $RentalRateModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $RentalRateModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);

                      $RentalRateModel->save(false); */
                }

                /*
                 * BID TIME
                 */
                foreach ($BidTime["ryb_bid_time_minute"] as $Time) {

                    /*
                     * INSERT INTO ryb_bid_time_master (ryb_bid_time_minute, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id) values
                      (5,940,2868,25,17,6),
                      (10,941,2897,25,17,6),
                      (15,941,2897,25,17,6),
                      (20,941,2897,25,17,6),
                      (25,941,2897,25,17,6),
                      (30,941,2897,25,17,6);
                     */

                    $InsertQueries["BidTimeMaster"][] = "({$Time},{$ConfPackageID},{$PincodeData["ryb_pincode_id"]},{$PincodeData["ryb_city_id"]},{$PincodeData["ryb_state_id"]},{$PincodeData["ryb_country_id"]})";

                    /* $BidTimeModel = new \app\models\BidTimeMaster();

                      $BidTimeModel->setAttribute("ryb_bid_time_minute", $Time);
                      $BidTimeModel->setAttribute("ryb_conf_package_id", $ConfPackageID);
                      $BidTimeModel->setAttribute("ryb_pincode_id", $PincodeData["ryb_pincode_id"]);
                      $BidTimeModel->setAttribute("ryb_city_id", $PincodeData["ryb_city_id"]);
                      $BidTimeModel->setAttribute("ryb_state_id", $PincodeData["ryb_state_id"]);
                      $BidTimeModel->setAttribute("ryb_country_id", $PincodeData["ryb_country_id"]);
                      $BidTimeModel->save(false); */
                }
            }

            $RateCardQuery = "INSERT INTO ryb_rate_card_master
                              (ryb_rate_card_pr_km, ryb_time_slot_id, ryb_cabtype_id, ryb_ride_type_id,
                              ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                              values " . implode(", ", $InsertQueries["RateCardMaster"]) . ";";
            $RentalRateQuery = "INSERT INTO ryb_rental_rate_card_master
                      (ryb_cabtype_id, ryb_ride_type_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id,
                      ryb_rental_rate_card_1hr, ryb_rental_rate_card_2hr, ryb_rental_rate_card_3hr, ryb_rental_rate_card_4hr,
                      ryb_rental_rate_card_5hr, ryb_rental_rate_card_6hr, ryb_rental_rate_card_7hr, ryb_rental_rate_card_8hr,
                      ryb_rental_rate_card_9hr, ryb_rental_rate_card_10hr, ryb_rental_rate_card_11hr, ryb_rental_rate_card_12hr)
                      values " . implode(", ", $InsertQueries["RentalRateCardMaster"]) . ";";
            $CommPercentQuery = "INSERT INTO ryb_comm_percent_master
                      (ryb_comm_percent_amt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values " . implode(", ", $InsertQueries["CommPercentMaster"]) . ";";
            $BidamntPercentQuery = "INSERT INTO ryb_bidamnt_percent_master
                      (ryb_bid_amnt_percent_amt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values " . implode(", ", $InsertQueries["BidamntPercentMaster"]) . ";";
            $PenaltyAmntQuery = "INSERT INTO ryb_penalty_amnt_master
                      (ryb_penalty_amnt, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id)
                      values " . implode(", ", $InsertQueries["PenaltyAmntMaster"]) . ";";
            $DriverRadiusQuery = "INSERT INTO ryb_driver_radius_master (ryb_driver_radius_metres, ryb_ride_type_id, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id) values " . implode(", ", $InsertQueries["DriverRadiusMaster"]) . ";";
            $BidTimeQuery = "INSERT INTO ryb_bid_time_master (ryb_bid_time_minute, ryb_conf_package_id, ryb_pincode_id, ryb_city_id, ryb_state_id, ryb_country_id) values " . implode(", ", $InsertQueries["BidTimeMaster"]) . ";";

            Yii::$app->db->createCommand($RateCardQuery)->execute();
            Yii::$app->db->createCommand($RentalRateQuery)->execute();
            Yii::$app->db->createCommand($CommPercentQuery)->execute();
            Yii::$app->db->createCommand($BidamntPercentQuery)->execute();
            Yii::$app->db->createCommand($PenaltyAmntQuery)->execute();
            Yii::$app->db->createCommand($DriverRadiusQuery)->execute();
            Yii::$app->db->createCommand($BidTimeQuery)->execute();

            return $this->redirect(["/site/index"]);
        }
        return $this->render('config-params', [
                    'CabTypeArray' => $CabTypeArray,
                    'RideTypeArray' => $RideTypeArray,
                    'CountryArray' => $CountryArray,
                    'TimeSlotArray' => $TimeSlotArray,
                    'SelectedPincode' => $SelectedPincode,
                    'SelectedState' => $SelectedState,
                    'SelectedCity' => $SelectedCity,
                    'SelectedCountry' => $SelectedCountry,
                    'FormUrl' => $FormUrl
        ]);
    }

    public function actionConfigCommon() {
        \Yii::$app->params["page_meta_data"]["page_title"] = "Common Parameters";
        $Tax = \app\models\TaxMaster::findOne(3);
        $CabTypeArray = \yii\helpers\ArrayHelper::map(\app\models\CabtypeMaster::find()->where(["ryb_status_id" => 2])->asArray()->all(), 'ryb_cabtype_id', 'ryb_cabtype_title');
        $RideTypeArray = \yii\helpers\ArrayHelper::map(\app\models\RideTypeMaster::find()->asArray()->all(), 'ryb_ride_type_id', 'ryb_ride_type_title');
        if (Yii::$app->request->post()) {
            foreach (Yii::$app->request->post('ryb_rental_package_master') as $key => $value) {
                foreach ($value["ryb_rental_package_km_allowed"] as $k => $v) {
                    $Rental = \app\models\RentalPackageMaster::find()->where(["ryb_cabtype_id" => $k, "ryb_rental_package_hour" => $key])->one();
                    if (!$Rental) {
                        $Rental = new \app\models\RentalPackageMaster();
                    }
                    $Rental->setAttribute("ryb_rental_package_hour", $key);
                    $Rental->setAttribute("ryb_cabtype_id", $k);
                    $Rental->setAttribute("ryb_rental_package_km_allowed", $v);
                    $Rental->setAttribute("ryb_rental_package_km_ext_charge", $value["ryb_rental_package_km_ext_charge"][$k]);
                    $Rental->setAttribute("ryb_rental_package_hr_ext_charge", $value["ryb_rental_package_hr_ext_charge"][$k]);
                    $Rental->save(false);
                }
            }
            foreach (Yii::$app->request->post('ryb_night_charge_master') as $key => $value) {
                $NightCharge = \app\models\NightChargeMaster::find()->where(["ryb_ride_type_id" => $key])->one();
                if (!$NightCharge) {
                    $NightCharge = new \app\models\NightChargeMaster();
                }
                $NightCharge->setAttribute("ryb_ride_type_id", $key);
                $NightCharge->setAttribute("ryb_night_charge", $value);
                $NightCharge->save(false);
            }
            foreach (Yii::$app->request->post('ryb_ride_waitng_master') as $key => $value) {
                $RideWaiting = \app\models\RideWaitngMaster::find()->where(["ryb_ride_type_id" => $key])->one();
                if (!$RideWaiting) {
                    $RideWaiting = new \app\models\RideWaitngMaster();
                }
                $RideWaiting->setAttribute("ryb_ride_type_id", $key);
                $RideWaiting->setAttribute("ryb_ride_waitng_time", $value["ryb_ride_waitng_time"]);
                $RideWaiting->setAttribute("ryb_ride_waitng_charges", $value["ryb_ride_waitng_charges"]);
                $RideWaiting->save(false);
            }
            $Tax->setAttribute("ryb_tax_percentage", Yii::$app->request->post('ryb_tax_master')["ryb_tax_percentage"]);
            $Tax->save(false);
            return $this->redirect(["/configuration/config-common"]);
        }
        return $this->render('config-common', [
                    'Tax' => $Tax,
                    'CabTypeArray' => $CabTypeArray,
                    'RideTypeArray' => $RideTypeArray
        ]);
    }

}
