<?php

namespace app\controllers;

use Yii;

class DriverServiceController extends \app\controllers\RestController {

    public function actionRegister() {
        $this->_validateRequest(['fullname', 'emailid', 'phoneno', 'password', 'login_method']);
        try {
            $User = new \app\models\UserMaster(['scenario' => 'api_register']);
            $User->setAttribute("ryb_user_fullname", $this->RequestData["fullname"]);
            $User->setAttribute("ryb_user_emailid", $this->RequestData["emailid"]);
            $User->setAttribute("ryb_user_phoneno", $this->RequestData["phoneno"]);
            $User->setAttribute("ryb_user_password", \Yii::$app->getSecurity()->generatePasswordHash($this->RequestData["password"]));
            $User->setAttribute("ryb_user_login_method", $this->RequestData["login_method"]);
            $User->setAttribute("ryb_user_type", "2");
            if ($User->save()) {
                $Driver = new \app\models\DriverMaster();
                $Driver->setAttribute("ryb_user_id", $User->ryb_user_id);
                $Driver->save();
                $User = \app\models\UserMaster::find()
                                ->select([
                                    "ryb_user_id AS user_id", "ryb_user_fullname AS fullname",
                                    "ryb_user_emailid AS emailid", "ryb_user_phoneno AS phoneno",
                                    "ryb_user_verify_status AS verify_status", "ryb_user_picture AS picture"
                                ])
                                ->where(['ryb_user_id' => $User->ryb_user_id])->asArray()->one();
                $User["driver_id"] = $Driver->ryb_driver_id;
                $NewWallet = new \app\models\UserWalletMaster();
                $NewWallet->setAttribute("ryb_user_id", $User["user_id"]);
                $NewWallet->save(false);
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: User registered",
                    "task_data" => $User
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($User->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionConfirmMobileNo() {
        $this->_validateRequest(['phoneno', 'user_id']);
        try {
            $User = \app\models\UserMaster::find()->where([
                        "ryb_user_phoneno" => $this->RequestData["phoneno"],
                        "ryb_user_id" => $this->RequestData["user_id"],
                        "ryb_user_verify_status" => false
                    ])->one();
            if ($User) {
                $User->setAttribute("ryb_user_verify_status", true);
                if ($User->save()) {
                    $User = \app\models\UserMaster::find()->select([
                                "ryb_user_id AS user_id", "ryb_user_fullname AS fullname", "ryb_user_emailid AS emailid",
                                "ryb_user_phoneno AS phoneno", "ryb_user_verify_status AS verify_status"
                            ])->where(["ryb_user_phoneno" => $this->RequestData["phoneno"]])->asArray()->one();
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: User verified",
                        "task_data" => $User
                    ]);
                }
            }
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: Invalid mobile no",
                "task_data" => []
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionLogin() {
        $this->_validateRequest(['phoneno', 'password', 'fcm_id']);
        try {
            $User = \app\models\UserMaster::find()
                            ->select([
                                "ryb_user_id AS user_id", "ryb_user_fullname AS fullname",
                                "ryb_user_emailid AS emailid", "ryb_user_phoneno AS phoneno",
                                "ryb_user_password AS password", "ryb_user_verify_status AS verify_status",
                                "ryb_user_picture AS picture"
                            ])
                            ->where([
                                "ryb_user_phoneno" => $this->RequestData["phoneno"],
                                "ryb_user_verify_status" => true,
                                "ryb_status_id" => 2,
                                "ryb_user_type" => 2
                                    #"ryb_user_login_method" => 1
                            ])
                            ->asArray()->one();
            if (($User && $User["password"] != "") && \Yii::$app->getSecurity()->validatePassword($this->RequestData["password"], $User["password"])) {
                $User["password"] = "";
                $User["driver_id"] = (\app\models\DriverMaster::find()->where(["ryb_user_id" => $User["user_id"]])->asArray()->one())["ryb_driver_id"];

                if ($this->RequestData["fcm_id"]) {
                    $UserFCM = \app\models\UserMaster::findOne($User["user_id"]);
                    $UserFCM->setAttribute("ryb_user_fcm_id", $this->RequestData["fcm_id"]);
                    $UserFCM->save(false);
                }

                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Login success",
                    "task_data" => $User
                ]);
            }
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: Invalid Phone No or Password",
                "task_data" => []
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionFetchCabType() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Cab types Found!",
                "task_data" => array_map(function ($CabType) {
                            $CabType["cab_type_icon"] = \Yii::$app->request->hostInfo . $CabType["cab_type_icon"];
                            return $CabType;
                        }, \app\models\CabtypeMaster::find()
                                ->select([
                                    "ryb_cabtype_id AS cab_type_id",
                                    "ryb_cabtype_title AS cab_type_title",
                                    "ryb_cabtype_icon AS cab_type_icon",
                                    "ryb_cabtype_seating AS cab_type_seating",
                                    "ryb_cabtype_description AS cab_type_description"
                                ])
                                ->where(["ryb_status_id" => 2])
                                ->asArray()->all()),
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionAddDriverCab() {
        $this->_validateRequest([
            'user_id', 'driver_id', 'cab_brand', 'cab_model', 'cab_make_year', 'cab_exterior_color', 'cab_interior_color', 'driver_license_no',
            'driver_license_expiry', 'cab_chasis_no', 'cab_reg_no', 'cab_permit_no', 'cab_permit_expiry', 'cab_insurance_no', 'cab_insurance_expiry'
        ]);
        try {
            $model = \app\models\DriverCabMaster::find()->where([
                        "ryb_driver_id" => $this->RequestData["driver_id"],
                    ])->one();
            if ($model) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Cab has been already registered!",
                    "task_data" => []
                ]);
            }
            $model = new \app\models\DriverCabMaster();
            $model->setAttribute("ryb_driver_id", $this->RequestData["driver_id"]);
            $model->setAttribute("ryb_driver_cab_status_id", 1);
            $model->setAttribute("ryb_driver_cab_brand", $this->RequestData["cab_brand"]);
            $model->setAttribute("ryb_driver_cab_model", $this->RequestData["cab_model"]);
            $model->setAttribute("ryb_driver_cab_make_year", $this->RequestData["cab_make_year"]);
            $model->setAttribute("ryb_driver_cab_exterior_color", $this->RequestData["cab_exterior_color"]);
            $model->setAttribute("ryb_driver_cab_interior_color", $this->RequestData["cab_interior_color"]);
            $model->setAttribute("ryb_driver_license_no", $this->RequestData["driver_license_no"]);
            $model->setAttribute("ryb_driver_license_expiry", $this->RequestData["driver_license_expiry"]);
            $model->setAttribute("ryb_driver_cab_chasis_no", $this->RequestData["cab_chasis_no"]);
            $model->setAttribute("ryb_driver_cab_reg_no", $this->RequestData["cab_reg_no"]);
            $model->setAttribute("ryb_driver_cab_permit_no", $this->RequestData["cab_permit_no"]);
            $model->setAttribute("ryb_driver_cab_permit_expiry", $this->RequestData["cab_permit_expiry"]);
            $model->setAttribute("ryb_driver_cab_insurance_no", $this->RequestData["cab_insurance_no"]);
            $model->setAttribute("ryb_driver_cab_insurance_expiry", $this->RequestData["cab_insurance_expiry"]);

            $driver_license_cert = \yii\web\UploadedFile::getInstanceByName('data[driver_license_cert]');
            if ($driver_license_cert) {
                $FileName = uniqid("IMG_", true) . "." . $driver_license_cert->extension;
                $model->setAttribute("ryb_driver_license_cert", $this->uploadUserFileAPI($driver_license_cert, $FileName));
            }
            $cab_reg_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_reg_cert]');
            if ($cab_reg_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_reg_cert->extension;
                $model->setAttribute("ryb_driver_cab_reg_cert", $this->uploadUserFileAPI($cab_reg_cert, $FileName));
            }
            $cab_permit_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_permit_cert]');
            if ($cab_permit_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_permit_cert->extension;
                $model->setAttribute("ryb_driver_cab_permit_cert", $this->uploadUserFileAPI($cab_permit_cert, $FileName));
            }
            $cab_insurance_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_insurance_cert]');
            if ($cab_insurance_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_insurance_cert->extension;
                $model->setAttribute("ryb_driver_cab_insurance_cert", $this->uploadUserFileAPI($cab_insurance_cert, $FileName));
            }
            if ($model->save()) {
                $DriverCab = \app\models\DriverCabMaster::find()
                                ->select([
                                    "ryb_driver_cab_id AS cab_id", "ryb_driver_cab_status_id AS cab_status_id", "ryb_driver_cab_brand AS cab_brand",
                                    "ryb_driver_cab_model AS cab_model", "ryb_driver_cab_make_year AS cab_make_year", "ryb_driver_cab_exterior_color AS cab_exterior_color",
                                    "ryb_driver_cab_interior_color AS cab_interior_color", "ryb_driver_license_no AS driver_license_no", "ryb_driver_license_cert AS driver_license_cert",
                                    "ryb_driver_license_expiry AS driver_license_expiry", "ryb_driver_cab_chasis_no AS cab_chasis_no", "ryb_driver_cab_reg_no AS cab_reg_no",
                                    "ryb_driver_cab_reg_cert AS cab_reg_cert", "ryb_driver_cab_permit_no AS cab_permit_no", "ryb_driver_cab_permit_cert AS cab_permit_cert",
                                    "ryb_driver_cab_permit_expiry AS cab_permit_expiry", "ryb_driver_cab_insurance_no AS cab_insurance_no",
                                    "ryb_driver_cab_insurance_cert AS cab_insurance_cert", "ryb_driver_cab_insurance_expiry AS cab_insurance_expiry",
                                    "ryb_driver_cab_image AS cab_image"
                                ])
                                ->where(["ryb_driver_id" => $model->ryb_driver_id])
                                ->asArray()->one();
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Vehicle Added",
                    "task_data" => $DriverCab
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($model->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionGetProfile() {
        $this->_validateRequest(['user_id', 'driver_id']);
        try {
            $User = \app\models\UserMaster::find()
                            ->select([
                                "ryb_user_id AS user_id", "ryb_user_fullname AS fullname", "ryb_user_emailid AS emailid",
                                "ryb_user_login_method AS login_method", "ryb_user_phoneno AS phoneno", "ryb_user_picture AS picture",
                                "ryb_user_addr_work AS address_work", "ryb_user_addr_home AS address_home", "ryb_user_addedat AS registered_at"
                            ])
                            ->where([
                                "ryb_user_id" => $this->RequestData["user_id"],
                                "ryb_status_id" => 2,
                                "ryb_user_type" => 2,
                                "ryb_user_verify_status" => true
                            ])->asArray()->one();
            if ($User) {
                $DriverCab = \app\models\DriverCabMaster::find()
                                ->select([
                                    "ryb_driver_cab_id AS cab_id", "ryb_driver_cab_status_id AS cab_status_id", "ryb_driver_cab_brand AS cab_brand",
                                    "ryb_driver_cab_model AS cab_model", "ryb_driver_cab_make_year AS cab_make_year", "ryb_driver_cab_exterior_color AS cab_exterior_color",
                                    "ryb_driver_cab_interior_color AS cab_interior_color", "ryb_driver_license_no AS driver_license_no", "ryb_driver_license_cert AS driver_license_cert",
                                    "ryb_driver_license_expiry AS driver_license_expiry", "ryb_driver_cab_chasis_no AS cab_chasis_no", "ryb_driver_cab_reg_no AS cab_reg_no",
                                    "ryb_driver_cab_reg_cert AS cab_reg_cert", "ryb_driver_cab_permit_no AS cab_permit_no", "ryb_driver_cab_permit_cert AS cab_permit_cert",
                                    "ryb_driver_cab_permit_expiry AS cab_permit_expiry", "ryb_driver_cab_insurance_no AS cab_insurance_no",
                                    "ryb_driver_cab_insurance_cert AS cab_insurance_cert", "ryb_driver_cab_insurance_expiry AS cab_insurance_expiry",
                                    "ryb_driver_cab_image AS cab_image"
                                ])
                                ->where([
                                    "ryb_driver_id" => $this->RequestData["driver_id"]
                                ])->asArray()->one();
                $User["driver_id"] = $this->RequestData["driver_id"];
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: User profile found",
                    "task_data" => [
                        "Driver" => $User,
                        "DriverCab" => $DriverCab,
                        "DriverStatus" => \app\models\DriverCabStatusMaster::find()->select([
                            "ryb_driver_cab_status_id AS cab_status_id",
                            "ryb_driver_cab_status_text AS cab_status_text"
                        ])->asArray()->all()
                    ]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid User Id",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionEditProfile() {
        $this->_validateRequest(['user_id', 'fullname', 'emailid', 'phoneno', 'address_home', 'address_work', 'password', 'driver_id']);
        try {
            $User = \app\models\UserMaster::findOne($this->RequestData["user_id"]);
            if (!$User) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid User or Driver!",
                    "task_data" => []
                ]);
            }
            $User->setAttribute("ryb_user_fullname", $this->RequestData["fullname"]);
            $User->setAttribute("ryb_user_emailid", $this->RequestData["emailid"]);
            $User->setAttribute("ryb_user_phoneno", $this->RequestData["phoneno"]);
            $User->setAttribute("ryb_user_addr_work", $this->RequestData["address_work"]);
            $User->setAttribute("ryb_user_addr_home", $this->RequestData["address_home"]);
            if ($this->RequestData["password"] != "") {
                $User->setAttribute("ryb_user_password", \Yii::$app->getSecurity()->generatePasswordHash($this->RequestData["password"]));
            }
            $UploadedImage = \yii\web\UploadedFile::getInstanceByName('data[picture]');
            if ($UploadedImage) {
                $FileName = uniqid("IMG_", true) . "." . $UploadedImage->extension;
                $User->setAttribute("ryb_user_picture", $this->uploadUserFileAPI($UploadedImage, $FileName));
            } else {
                $User->setAttribute("ryb_user_picture", $User->ryb_user_picture);
            }
            if ($User->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Profile updated!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($User->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionEditDriverCab() {
        $this->_validateRequest([
            'user_id', 'driver_id', 'cab_brand', 'cab_model', 'cab_make_year', 'cab_exterior_color', 'cab_interior_color', 'driver_license_no',
            'driver_license_expiry', 'cab_chasis_no', 'cab_reg_no', 'cab_permit_no', 'cab_permit_expiry', 'cab_insurance_no', 'cab_insurance_expiry'
        ]);
        try {
            $model = \app\models\DriverCabMaster::find()->where([
                        "ryb_driver_id" => $this->RequestData["driver_id"],
                    ])->one();
            if (!$model) {
                $model = new \app\models\DriverCabMaster();
                $model->setAttribute("ryb_driver_id", $this->RequestData["driver_id"]);
            }
            $model->setAttribute("ryb_driver_cab_brand", $this->RequestData["cab_brand"]);
            $model->setAttribute("ryb_driver_cab_model", $this->RequestData["cab_model"]);
            $model->setAttribute("ryb_driver_cab_make_year", $this->RequestData["cab_make_year"]);
            $model->setAttribute("ryb_driver_cab_exterior_color", $this->RequestData["cab_exterior_color"]);
            $model->setAttribute("ryb_driver_cab_interior_color", $this->RequestData["cab_interior_color"]);
            $model->setAttribute("ryb_driver_license_no", $this->RequestData["driver_license_no"]);
            $model->setAttribute("ryb_driver_license_expiry", $this->RequestData["driver_license_expiry"]);
            $model->setAttribute("ryb_driver_cab_chasis_no", $this->RequestData["cab_chasis_no"]);
            $model->setAttribute("ryb_driver_cab_reg_no", $this->RequestData["cab_reg_no"]);
            $model->setAttribute("ryb_driver_cab_permit_no", $this->RequestData["cab_permit_no"]);
            $model->setAttribute("ryb_driver_cab_permit_expiry", $this->RequestData["cab_permit_expiry"]);
            $model->setAttribute("ryb_driver_cab_insurance_no", $this->RequestData["cab_insurance_no"]);
            $model->setAttribute("ryb_driver_cab_insurance_expiry", $this->RequestData["cab_insurance_expiry"]);
            $driver_license_cert = \yii\web\UploadedFile::getInstanceByName('data[driver_license_cert]');
            if ($driver_license_cert) {
                $FileName = uniqid("IMG_", true) . "." . $driver_license_cert->extension;
                $model->setAttribute("ryb_driver_license_cert", $this->uploadUserFileAPI($driver_license_cert, $FileName));
            } else {
                $model->setAttribute("ryb_driver_license_cert", $model->ryb_driver_license_cert);
            }

            $cab_reg_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_reg_cert]');
            if ($cab_reg_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_reg_cert->extension;
                $model->setAttribute("ryb_driver_cab_reg_cert", $this->uploadUserFileAPI($cab_reg_cert, $FileName));
            } else {
                $model->setAttribute("ryb_driver_cab_reg_cert", $model->ryb_driver_cab_reg_cert);
            }

            $cab_permit_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_permit_cert]');
            if ($cab_permit_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_permit_cert->extension;
                $model->setAttribute("ryb_driver_cab_permit_cert", $this->uploadUserFileAPI($cab_permit_cert, $FileName));
            } else {
                $model->setAttribute("ryb_driver_cab_permit_cert", $model->ryb_driver_cab_permit_cert);
            }

            $cab_insurance_cert = \yii\web\UploadedFile::getInstanceByName('data[cab_insurance_cert]');
            if ($cab_insurance_cert) {
                $FileName = uniqid("IMG_", true) . "." . $cab_insurance_cert->extension;
                $model->setAttribute("ryb_driver_cab_insurance_cert", $this->uploadUserFileAPI($cab_insurance_cert, $FileName));
            } else {
                $model->setAttribute("ryb_driver_cab_insurance_cert", $model->ryb_driver_cab_insurance_cert);
            }

            $cab_image = \yii\web\UploadedFile::getInstanceByName('data[cab_image]');
            if ($cab_image) {
                $FileName = uniqid("IMG_", true) . "." . $cab_image->extension;
                $model->setAttribute("ryb_driver_cab_image", $this->uploadUserFileAPI($cab_image, $FileName));
            } else {
                $model->setAttribute("ryb_driver_cab_image", $model->ryb_driver_cab_image);
            }

            if ($model->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Cab Updated",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($model->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionWalletPayoutList() {
        $this->_validateRequest(['user_id']);
        try {
            $WalletPayoutArray = \app\models\UserWalletTransMaster::find()
                            ->select([
                                "ryb_user_wallet_trans_id AS transaction_id", "ryb_user_wallet_trans_code AS transaction_code",
                                "ryb_user_wallet_trans_remark AS payout_remark", "ryb_user_wallet_trans_total_amnt AS payout_amount",
                                "ryb_user_wallet_trans_status AS payout_status", "ryb_user_wallet_trans_datetime AS payout_datetime"
                            ])
                            ->where([
                                "ryb_user_id" => $this->RequestData["user_id"],
                                "ryb_user_wallet_trans_category_id" => 5
                            ])->asArray()->all();
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Payout list found!",
                "task_data" => [
                    "PayoutStatus" => [
                        1 => "Pending",
                        2 => "Approved",
                        3 => "Failed"
                    ],
                    "PayoutArray" => array_map(function ($v) {
                                $v["payout_datetime"] = date("h:i d-m-Y", strtotime($v["payout_datetime"]));
                                return $v;
                            }, $WalletPayoutArray)
                ],
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionWalletPayout() {
        $this->_validateRequest([
            'user_id', 'payout_amount', 'payout_remark',
        ]);
        try {
            $UserWallet = \app\models\UserWalletMaster::find()->where([
                        "ryb_user_id" => $this->RequestData["user_id"]
                    ])->asArray()->one();
            if ($this->RequestData["payout_amount"] < $UserWallet["ryb_user_wallet_balance"]) {
                $TransactionCode = $this->generateRandomString(6);
                $WalletTransModel = new \app\models\UserWalletTransMaster();
                $WalletTransModel->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
                $WalletTransModel->setAttribute("ryb_user_wallet_id", $UserWallet["ryb_user_wallet_id"]);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_amnt", $this->RequestData["payout_amount"]);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_total_amnt", $this->RequestData["payout_amount"]);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_remark", $TransactionCode . "-Payout: [" . $this->RequestData["payout_remark"] . "]");
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_type", 2);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_status", 1);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_code", $TransactionCode);
                $WalletTransModel->setAttribute("ryb_user_wallet_trans_category_id", 5);
                if ($WalletTransModel->save()) {
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Payout request saved, Will be processed in 3-5 business days.",
                        "task_data" => []
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($WalletTransModel->errors),
                        "task_data" => []
                    ]);
                }
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Insufficient wallet balance!",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionDashboard() {
        $this->_validateRequest(['user_id', 'driver_id']);
        try {
            $model = \app\models\DriverCabMaster::find()->where([
                        "ryb_driver_id" => $this->RequestData["driver_id"],
                            //"ryb_driver_cab_status_id"=>3
                    ])->one();
            if (!$model) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Driver or Cab not approved!",
                    "task_data" => []
                ]);
            }
            $Wallet = \app\models\UserWalletMaster::find()
                    ->select([
                        "ryb_user_wallet_id AS wallet_id",
                        "ryb_user_wallet_balance AS wallet_balance",
                        "ryb_user_wallet_updated_at AS last_updated"
                    ])
                    ->where(["ryb_user_id" => $this->RequestData["user_id"]])
                    ->asArray()
                    ->one();
            $Wallet["last_updated"] = date("h:i A", strtotime($Wallet["last_updated"]));
            $Driver = \app\models\DriverMaster::find()
                            ->select([
                                "ryb_driver_id AS driver_id", "ryb_user_id AS user_id", "ryb_driver_is_online AS driver_is_online",
                                "ryb_driver_pref_is_daily AS driver_pref_is_daily", "ryb_driver_pref_is_outstation AS driver_pref_is_outstation",
                                "ryb_driver_pref_is_rental AS driver_pref_is_rental", "ryb_driver_pref_is_airport AS driver_pref_is_airport"
                            ])
                            ->where(["ryb_driver_id" => $this->RequestData["driver_id"]])
                            ->asArray()->one();

            /* TO CHANGE */

            $RideArray = \app\models\UserRideMaster::find()
                    ->select([
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_ride_master.ryb_ride_type_id AS ride_type_id",
                        "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_pincode_id AS pincode_id",
                        "ryb_user_ride_master.ryb_user_payment_mode AS ride_payment_mode",
                        "ryb_user_ride_master.ryb_user_ride_est_fare AS ride_estimated_fare",
                        "ryb_user_ride_master.ryb_user_ride_est_dist AS ride_estimated_time",
                        "ryb_user_ride_master.ryb_user_ride_bid_time AS ride_bid_time",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_master.ryb_user_ride_registered_at AS ride_booked_at",
                        "ryb_user_master.ryb_user_id AS ride_user_id",
                        "ryb_user_master.ryb_user_fullname AS user_fullname",
                        "ryb_user_master.ryb_user_picture AS user_picture",
                        "ryb_ride_type_master.ryb_ride_type_title AS ride_type_title"
                    ])
                    ->where(["ryb_user_ride_master.ryb_ride_status_id" => 1])
                    ->orderBy("ryb_user_ride_master.ryb_user_ride_id DESC")
                    ->joinWith(["rybUser", "rybRideType"])
                    ->limit(11)
                    ->asArray()
                    ->all();
            $RideType = \app\models\RideTypeMaster::find()->select([
                        "ryb_ride_type_id AS ride_type_id",
                        "ryb_ride_type_title AS ride_type_title",
                    ])->orderBy("ride_type_id ASC")->asArray()->all();
            $FocusedBid = [];
            if (count($RideArray) > 0) {
                $RideArray = array_map(function ($v) {
                    $v["pickup_full_location"] = (array) json_decode($v["pickup_full_location"]);
                    $v["drop_full_location"] = (array) json_decode($v["drop_full_location"]);
                    $v["ride_booked_at"] = date("h:i A d-m-Y", strtotime($v["ride_booked_at"]));
                    unset($v["rybUser"]);
                    unset($v["rybRideType"]);
                    return array_filter($v);
                }, array_reverse($RideArray));
                $FocusedBid = array_pop($RideArray);

                /* TO CHANGE */

                $BidPercentage = \app\models\BidamntPercentMaster::find()->where([
                            "ryb_pincode_id" => $FocusedBid["pincode_id"]
                        ])->asArray()->one();
                $FocusedBid["min_bid_amount"] = round($FocusedBid["ride_estimated_fare"] - (($FocusedBid["ride_estimated_fare"] * $BidPercentage["ryb_bid_amnt_percent_amt"]) / 100));
                $FocusedBid["max_bid_amount"] = round($FocusedBid["ride_estimated_fare"] + (($FocusedBid["ride_estimated_fare"] * $BidPercentage["ryb_bid_amnt_percent_amt"]) / 100));
                $RideType[0] = array_merge($RideType[0], ["driver_pref_enabled" => $Driver["driver_pref_is_daily"]]);
                $RideType[1] = array_merge($RideType[1], ["driver_pref_enabled" => $Driver["driver_pref_is_outstation"]]);
                $RideType[2] = array_merge($RideType[2], ["driver_pref_enabled" => $Driver["driver_pref_is_rental"]]);
                $RideType[3] = array_merge($RideType[3], ["driver_pref_enabled" => $Driver["driver_pref_is_airport"]]);
            }
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Dashboard data found!",
                "task_data" => [
                    "Wallet" => $Wallet,
                    "RideType" => $RideType,
                    "DriverStatus" => $Driver,
                    "FocusedBid" => $FocusedBid,
                    "RideArray" => $RideArray,
                ]
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionMarkDriverOnline() {
        $this->_validateRequest(['user_id', 'driver_id', 'driver_is_online']);
        try {
            $Driver = \app\models\DriverMaster::findOne($this->RequestData["driver_id"]);
            if (!$Driver) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Driver!",
                    "task_data" => []
                ]);
            }
            $Driver->setAttribute("ryb_driver_is_online", $this->RequestData["driver_is_online"]);
            if ($Driver->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Driver marked!",
                    "task_data" => ["driver_is_online" => (bool) $this->RequestData["driver_is_online"]]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($Driver->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionModifyPreference() {
        $this->_validateRequest(['user_id', 'driver_id', 'driver_pref']);
        try {
            $Driver = \app\models\DriverMaster::findOne($this->RequestData["driver_id"]);
            if (!$Driver) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Driver!",
                    "task_data" => []
                ]);
            }
            $Driver->setAttribute("ryb_driver_pref_is_daily", $this->RequestData["driver_pref"][1]);
            $Driver->setAttribute("ryb_driver_pref_is_outstation", $this->RequestData["driver_pref"][2]);
            $Driver->setAttribute("ryb_driver_pref_is_rental", $this->RequestData["driver_pref"][3]);
            $Driver->setAttribute("ryb_driver_pref_is_airport", $this->RequestData["driver_pref"][4]);
            $RideType = \app\models\RideTypeMaster::find()->select([
                        "ryb_ride_type_id AS ride_type_id",
                        "ryb_ride_type_title AS ride_type_title",
                    ])->orderBy("ride_type_id ASC")->asArray()->all();
            $RideType[0] = array_merge($RideType[0], ["driver_pref_enabled" => (bool) $Driver->ryb_driver_pref_is_daily]);
            $RideType[1] = array_merge($RideType[1], ["driver_pref_enabled" => (bool) $Driver->ryb_driver_pref_is_outstation]);
            $RideType[2] = array_merge($RideType[2], ["driver_pref_enabled" => (bool) $Driver->ryb_driver_pref_is_rental]);
            $RideType[3] = array_merge($RideType[3], ["driver_pref_enabled" => (bool) $Driver->ryb_driver_pref_is_airport]);
            if ($Driver->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Driver preference changed!",
                    "task_data" => $RideType
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($Driver->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionBidRide() {
        $this->_validateRequest(['user_id', 'driver_id', 'ride_id']);
        try {
            $model = \app\models\UserRideMaster::find()
                    ->select([
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_ride_master.ryb_ride_type_id AS ride_type_id",
                        "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_pincode_id AS pincode_id",
                        "ryb_user_ride_master.ryb_user_payment_mode AS ride_payment_mode",
                        "ryb_user_ride_master.ryb_user_ride_est_fare AS ride_estimated_fare",
                        "ryb_user_ride_master.ryb_user_ride_bid_time AS ride_bid_time",
                        "ryb_user_ride_master.ryb_user_ride_est_dist AS ride_estimated_time",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_master.ryb_user_ride_registered_at AS ride_booked_at",
                        "ryb_user_master.ryb_user_id AS ride_user_id",
                        "ryb_user_master.ryb_user_fullname AS user_fullname",
                        "ryb_user_master.ryb_user_picture AS user_picture",
                        "ryb_ride_type_master.ryb_ride_type_title AS ride_type_title"
                    ])
                    ->where([
                        "ryb_user_ride_master.ryb_ride_status_id" => 1,
                        "ryb_user_ride_master.ryb_user_ride_id" => $this->RequestData["ride_id"]
                    ])
                    ->joinWith(["rybUser", "rybRideType"])
                    ->asArray()
                    ->one();
            if (!$model) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Ride!",
                    "task_data" => []
                ]);
            }
            $BidPercentage = \app\models\BidamntPercentMaster::find()->where(["ryb_pincode_id" => $model["pincode_id"]])->asArray()->one();
            $model["min_bid_amount"] = round($model["ride_estimated_fare"] - (($model["ride_estimated_fare"] * $BidPercentage["ryb_bid_amnt_percent_amt"]) / 100));
            $model["max_bid_amount"] = round($model["ride_estimated_fare"] + (($model["ride_estimated_fare"] * $BidPercentage["ryb_bid_amnt_percent_amt"]) / 100));

            $model["pickup_full_location"] = (array) json_decode($model["pickup_full_location"]);
            $model["drop_full_location"] = (array) json_decode($model["drop_full_location"]);
            $model["ride_booked_at"] = date("h:i A d-m-Y", strtotime($model["ride_booked_at"]));

            unset($model["rybUser"]);
            unset($model["rybRideType"]);

            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Ride found!",
                "task_data" => $model
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionPlaceBidRide() {
        $this->_validateRequest(['driver_id', 'ride_id', 'bid_price', 'bid_eta', 'ride_user_id']);
        try {
            $BidRideModel = new \app\models\UserRideBidMaster();
            $BidRideModel->setAttribute("ryb_user_id", $this->RequestData["ride_user_id"]);
            $BidRideModel->setAttribute("ryb_user_ride_id", $this->RequestData["ride_id"]);
            $BidRideModel->setAttribute("ryb_driver_id", $this->RequestData["driver_id"]);
            $BidRideModel->setAttribute("ryb_user_ride_bid_price", $this->RequestData["bid_price"]);
            $BidRideModel->setAttribute("ryb_user_ride_bid_eta", $this->RequestData["bid_eta"]);
            $BidRideModel->setAttribute("ryb_user_ride_bid_status", 1);
            if ($BidRideModel->save()) {
                $Ride = \app\models\UserRideMaster::findOne($this->RequestData["ride_id"]);
                $Ride->setAttribute("ryb_ride_status_id", 3);
                $Ride->save(false);
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride bid saved!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($BidRideModel->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionBidList() {
        $this->_validateRequest(['driver_id', 'user_id', 'ride_status']);
        try {
            $RideBidArray = \app\models\UserRideBidMaster::find()
                    ->select([
                        "ryb_user_ride_bid_id AS ride_bid_id",
                        "ryb_user_ride_bid_price AS ride_bid_price",
                        "ryb_user_ride_bid_eta AS ride_bid_eta",
                        "ryb_user_ride_bid_status AS ride_bid_status",
                        "ryb_user_ride_bid_added_at AS ride_bid_added_at",
                        "ryb_user_master.ryb_user_id AS ride_user_id",
                        "ryb_user_master.ryb_user_fullname AS user_fullname",
                        "ryb_user_master.ryb_user_picture AS user_picture",
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_master.ryb_user_ride_est_fare AS ride_fare",
                        "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_master.ryb_ride_status_id AS ride_status",
                    ])
                    ->where([
                        "ryb_driver_id" => $this->RequestData["driver_id"],
                        "ryb_user_ride_bid_status" => $this->RequestData["ride_status"]
                    ])
                    ->joinWith(["rybUser", "rybUserRide"])
                    ->asArray()
                    ->all();
            if (count($RideBidArray) > 0) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride bids found!",
                    "task_data" => array_map(function ($v) {
                                $v["ride_bid_added_at"] = date("h:i A d-m-Y", strtotime($v["ride_bid_added_at"]));
                                $v["pickup_full_location"] = (array) json_decode($v["pickup_full_location"]);
                                $v["drop_full_location"] = (array) json_decode($v["drop_full_location"]);
                                unset($v["rybUser"]);
                                unset($v["rybUserRide"]);
                                return $v;
                            }, $RideBidArray)
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: No ride bids found!",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionRideAuthorize() {
        $this->_validateRequest(['driver_id', 'user_id', 'ride_id', 'ride_otp']);
        try {
            $DriverRideBid = \app\models\UserRideBidMaster::find()
                    ->where([
                        "ryb_user_ride_bid_master.ryb_driver_id" => $this->RequestData["driver_id"],
                        "ryb_user_ride_bid_master.ryb_user_ride_id" => $this->RequestData["ride_id"],
                        "ryb_user_ride_master.ryb_user_ride_otp" => $this->RequestData["ride_otp"],
                        "ryb_user_ride_bid_master.ryb_user_ride_bid_status" => 2,
                        "ryb_user_ride_master.ryb_ride_status_id" => 4,
                    ])
                    ->joinWith(["rybUserRide"])
                    ->one();
            if ($DriverRideBid) {
                $DriverRideBid->rybUserRide->setAttribute("ryb_ride_status_id", 5);
                $DriverRideBid->rybUserRide->setAttribute("ryb_user_ride_otp", "");
                $DriverRideBid->rybUserRide->save(false);
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: OTP Verified!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid OTP!",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionRideStatus() {
        $this->_validateRequest(['driver_id', 'user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Ride status found!",
                "task_data" => \app\models\RideStatusMaster::find()->select([
                    "ryb_ride_status_id AS ride_status_id",
                    "ryb_ride_status_text AS ride_status_text",
                ])->orderBy("ride_status_id ASC")->asArray()->all()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    /* public function actionRideOnTrip() {} */

    public function actionRideBillGenerate() {
        $this->_validateRequest(['driver_id', 'ride_bid_id', 'ride_id', 'ride_user_id', 'driver_mobile_time', 'ride_distance', 'ride_duration']);
        try {
            /* $RideTra = \app\models\UserRideTransMaster::find()->where(["ryb_user_ride_id" => $this->RequestData["ride_id"]])->one();
              if ($RideTra) {
              $this->_sendResponse(400, [
              "task_status" => 0,
              "task_message" => "Error: Ride bill already generated!",
              "task_data" => []
              ]);
              } */
            $Ride = \app\models\UserRideMaster::findOne($this->RequestData["ride_id"]);
            if ($Ride) {
                $RydoBidCommission = \app\models\CommPercentMaster::find()->where(["ryb_pincode_id" => $Ride["ryb_pincode_id"]])->asArray()->one();
                $BaseEstimatedFare = 0;
                if ($Ride->ryb_ride_type_id == 3) {
                    $BaseEstimatedFare = 10;
                } else {
                    $RateCard = \app\models\RateCardMaster::find()->where(["ryb_pincode_id" => $Ride["ryb_pincode_id"]])->asArray()->one();
                    $BaseEstimatedFare = ($RateCard["ryb_rate_card_pr_km"] * ($this->RequestData["ride_distance"] / 1000));
                }
                $ProcessingFee = (($BaseEstimatedFare * $RydoBidCommission["ryb_comm_percent_amt"]) / 100);
                $TotalEstimatedFare = ($BaseEstimatedFare + $ProcessingFee);
                $TaxAmount = (($TotalEstimatedFare * (\app\models\TaxMaster::findOne(3))->ryb_tax_percentage) / 100);
                $GrandTotal = round($TotalEstimatedFare + $TaxAmount);
                $RideTransaction = new \app\models\UserRideTransMaster();
                $RideTransaction->setAttribute("ryb_user_ride_bid_id", $this->RequestData["ride_bid_id"]);
                $RideTransaction->setAttribute("ryb_user_ride_id", $this->RequestData["ride_id"]);
                $RideTransaction->setAttribute("ryb_user_id", $this->RequestData["ride_user_id"]);
                $RideTransaction->setAttribute("ryb_user_ride_trans_status", 1);
                $RideTransaction->setAttribute("ryb_user_ride_fare", $BaseEstimatedFare);
                $RideTransaction->setAttribute("ryb_user_ride_processing_fee", $ProcessingFee);
                $RideTransaction->setAttribute("ryb_user_ride_tax_amount", $TaxAmount);
                $RideTransaction->setAttribute("ryb_user_ride_total_amount", $GrandTotal);
                $RideTransaction->setAttribute("ryb_user_ride_duration", $this->RequestData["ride_duration"]);
                $RideTransaction->setAttribute("ryb_user_ride_distance", $this->RequestData["ride_distance"]);
                if ($RideTransaction->save()) {
                    $TransDetail = \app\models\UserRideTransMaster::find()
                                    ->select([
                                        "ryb_user_ride_trans_id AS ride_trans_id", "ryb_user_ride_bid_id AS ride_bid_id", "ryb_user_ride_id AS ride_id",
                                        "ryb_user_id AS ride_user_id", "ryb_user_ride_trans_status AS ride_trans_status", "ryb_user_ride_fare AS ride_fare",
                                        "ryb_user_ride_processing_fee AS ride_processing_fee", "ryb_user_ride_total_amount AS ride_total_amount",
                                        "ryb_user_ride_tax_amount AS ride_tax_amount", "ryb_user_ride_duration AS ride_duration", "ryb_user_ride_distance AS ride_distance",
                                        "ryb_user_ride_trans_at AS ride_trans_at"
                                    ])
                                    ->where(["ryb_user_ride_trans_id" => $RideTransaction->ryb_user_ride_trans_id])->asArray()->one();
                    $RideDetail = [];
                    $RideDetail["ride_pickup_location"] = (array) json_decode($Ride->ryb_user_pickup_location);
                    $RideDetail["ride_drop_location"] = (array) json_decode($Ride->ryb_user_drop_location);
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Ride bill generated!",
                        "task_data" => array_merge($TransDetail, $RideDetail)
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($RideTransaction->errors),
                        "task_data" => []
                    ]);
                }
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Ride!",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionRideBillPayment() {
        $this->_validateRequest(["ride_bill_id"]);
        try {
            $RideTransaction = \app\models\UserRideTransMaster::find()->where([
                        "ryb_user_ride_trans_id" => $this->RequestData["ride_bill_id"],
                        "ryb_user_ride_trans_status" => [1, 3]
                    ])->one();
            if (!$RideTransaction) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid ride bill!",
                    "task_data" => []
                ]);
            }
            $RideTransaction->setAttribute("ryb_user_ride_trans_status", 2);
            if ($RideTransaction->save()) {
                $Ride = \app\models\UserRideMaster::findOne($RideTransaction->ryb_user_ride_id);
                $Ride->setAttribute("ryb_ride_status_id", 6);
                $Ride->save();
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Bill payment collected!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($RideTransaction->errors),
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionRideList() {
        $this->_validateRequest(['driver_id', 'page_no', 'transaction_status']);
        try {
            $RideArray = \app\models\UserRideTransMaster::find()
                    ->select([
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_trans_master.ryb_user_ride_total_amount AS ride_total_amount",
                        "ryb_user_master.ryb_user_id AS ride_user_id",
                        "ryb_user_master.ryb_user_fullname AS user_fullname",
                        "ryb_user_master.ryb_user_picture AS user_picture",
                    ])
                    ->where([
                        "ryb_user_ride_bid_master.ryb_driver_id" => $this->RequestData["driver_id"],
                        "ryb_user_ride_trans_master.ryb_user_ride_trans_status" => $this->RequestData["transaction_status"],
                    ])
                    ->joinWith(["rybUserRideBid", "rybUserRide", "rybUserRide.rybUser"])
                    ->orderBy("ryb_user_ride_master.ryb_user_ride_id DESC")
                    ->asArray()
                    ->all();
            if (count($RideArray) > 0) {
                $ResponseArray = [];
                foreach ($RideArray as $key => $value) {
                    $value["pickup_full_location"] = ((array) json_decode($value["pickup_full_location"]))["location"];
                    $value["drop_full_location"] = ((array) json_decode($value["drop_full_location"]))["location"];
                    $value["ride_booked_at"] = date("h:i A d-m-Y", strtotime($value["ride_booked_at"]));
                    unset($value["rybUserRide"]);
                    unset($value["rybUserRideBid"]);
                    $ResponseArray[] = $value;
                }
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride list found!",
                    "task_data" => $ResponseArray
                ]);
            } else {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Error: No ride found!",
                    "task_data" => []
                ]);
            }
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

}
