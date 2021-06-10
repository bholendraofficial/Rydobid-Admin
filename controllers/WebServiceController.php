<?php

namespace app\controllers;

use Yii;

class WebServiceController extends \app\controllers\RestController {

    public function actionRegister() {
        $this->_validateRequest(['fullname', 'emailid', 'phoneno', 'password', 'login_method']);
        try {
            $User = new \app\models\UserMaster(['scenario' => 'api_register']);
            $User->setAttribute("ryb_user_fullname", $this->RequestData["fullname"]);
            $User->setAttribute("ryb_user_emailid", $this->RequestData["emailid"]);
            $User->setAttribute("ryb_user_phoneno", $this->RequestData["phoneno"]);
            $User->setAttribute("ryb_user_password", \Yii::$app->getSecurity()->generatePasswordHash($this->RequestData["password"]));
            $User->setAttribute("ryb_user_login_method", $this->RequestData["login_method"]);
            if ($User->save()) {
                $User = \app\models\UserMaster::find()
                                ->select([
                                    "ryb_user_id AS user_id", "ryb_user_fullname AS fullname",
                                    "ryb_user_emailid AS emailid", "ryb_user_phoneno AS phoneno",
                                    "ryb_user_verify_status AS verify_status", "ryb_user_picture AS picture"
                                ])
                                ->where(['ryb_user_id' => $User->ryb_user_id])->asArray()->one();
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
            $User = \app\models\UserMaster::find()->where(["ryb_user_id" => $this->RequestData["user_id"], "ryb_user_verify_status" => false])->one();
            if ($User) {
                $User->setAttribute("ryb_user_phoneno", $this->RequestData["phoneno"]);
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
                                    #"ryb_user_login_method" => 1
                            ])
                            ->asArray()->one();
            if (($User && $User["password"] != "") && \Yii::$app->getSecurity()->validatePassword($this->RequestData["password"], $User["password"])) {
                $User["password"] = "";
                if ($this->RequestData["fcm_id"] != "") {
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

    public function actionSocialLogin() {
        $this->_validateRequest(['emailid', 'phoneno', 'login_method', 'fullname', 'picture', 'fcm_id']);
        try {
            /* if ($this->RequestData["emailid"] == "" || $this->RequestData["phoneno"] == "") {
              $this->_sendResponse(400, [
              "task_status" => 0,
              "task_message" => "Error: Invalid request",
              "task_data" => []
              ]);
              } */
            $User = \app\models\UserMaster::find()
                            ->select([
                                "ryb_user_id AS user_id", "ryb_user_fullname AS fullname",
                                "ryb_user_emailid AS emailid", "ryb_user_phoneno AS phoneno",
                                "ryb_user_verify_status AS verify_status", "ryb_user_picture AS picture"
                            ])
                            ->where([
                                'or',
                                ["ryb_user_emailid" => ($this->RequestData["emailid"] ? $this->RequestData["emailid"] : 0)],
                                ["ryb_user_phoneno" => ($this->RequestData["phoneno"] ? $this->RequestData["phoneno"] : 0)]
                            ])
                            //->where(['IN', "ryb_user_login_method", [2, 3]])
                            ->asArray()->one();
            if (!$User) {
                $User = new \app\models\UserMaster(['scenario' => 'api_register_social']);
                $User->setAttribute("ryb_user_emailid", $this->RequestData["emailid"]);
                $User->setAttribute("ryb_user_phoneno", $this->RequestData["phoneno"]);
                $User->setAttribute("ryb_user_fullname", $this->RequestData["fullname"]);
                $User->setAttribute("ryb_user_login_method", $this->RequestData["login_method"]);
                $User->setAttribute("ryb_user_picture", $this->RequestData["picture"]);
                $User->setAttribute("ryb_user_fcm_id", $this->RequestData["fcm_id"]);
                #$User->setAttribute("ryb_user_verify_status", true);
                if ($User->save()) {
                    $User = \app\models\UserMaster::find()
                                    ->select([
                                        "ryb_user_id AS user_id", "ryb_user_fullname AS fullname",
                                        "ryb_user_emailid AS emailid", "ryb_user_phoneno AS phoneno",
                                        "ryb_user_verify_status AS verify_status", "ryb_user_picture AS picture"
                                    ])
                                    ->where(['ryb_user_id' => $User->ryb_user_id])->asArray()->one();
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Login success",
                        "task_data" => $User
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($User->errors),
                        "task_data" => []
                    ]);
                }
            } else {
                if ($this->RequestData["fcm_id"] != "") {
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
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionGetProfile() {
        $this->_validateRequest(['user_id']);
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
                                "ryb_user_verify_status" => true
                            ])->asArray()->one();
            if ($User) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: User profile found",
                    "task_data" => $User
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
        $this->_validateRequest(['user_id', 'fullname', 'emailid', 'phoneno', 'address_home', 'address_work', 'password']);
        try {
            $User = \app\models\UserMaster::findOne($this->RequestData["user_id"]);
            if (!$User) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid User Id",
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

    public function actionEmergencyContactList() {
        $this->_validateRequest(['user_id']);
        try {
            $EmergencyContact = \app\models\UserEmerContMaster::find()
                            ->select([
                                'ryb_user_emer_cont_id AS contact_id', 'ryb_user_emer_cont_name AS fullname', 'ryb_user_emer_cont_no AS contact_no',
                                'ryb_user_emer_cont_pic AS picture', 'ryb_user_emer_cont_is_active AS is_active', 'ryb_status_id AS status'
                            ])
                            ->where([
                                "ryb_user_id" => $this->RequestData["user_id"]
                            ])->asArray()->all();
            if (count($EmergencyContact) > 0) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Emergency contacts found!",
                    "task_data" => $EmergencyContact
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: No emergency contacts found!",
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

    public function actionEmergencyContactEdit() {
        $this->_validateRequest(['fullname', 'contact_no', 'contact_id', 'is_active', 'status']);
        try {
            $EmergencyContact = \app\models\UserEmerContMaster::findOne($this->RequestData["contact_id"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_name", $this->RequestData["fullname"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_no", $this->RequestData["contact_no"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_is_active", $this->RequestData["is_active"]);
            $EmergencyContact->setAttribute("ryb_status_id", $this->RequestData["status"]);
            $UploadedImage = \yii\web\UploadedFile::getInstanceByName('data[picture]');
            if ($UploadedImage) {
                $FileName = uniqid("IMG_", true) . "." . $UploadedImage->extension;
                $EmergencyContact->setAttribute("ryb_user_emer_cont_pic", $this->uploadUserFileAPI($UploadedImage, $FileName));
            } else {
                $EmergencyContact->setAttribute("ryb_user_emer_cont_pic", $EmergencyContact->ryb_user_emer_cont_pic);
            }
            if ($EmergencyContact->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Emergency contact edited!",
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

    public function actionEmergencyContactAdd() {
        $this->_validateRequest(['fullname', 'contact_no', 'user_id']);
        try {
            $EmergencyContact = new \app\models\UserEmerContMaster(["scenario" => "api_add"]);
            $EmergencyContact->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_name", $this->RequestData["fullname"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_no", $this->RequestData["contact_no"]);
            $EmergencyContact->setAttribute("ryb_user_emer_cont_is_active", true);
            $UploadedImage = \yii\web\UploadedFile::getInstanceByName('data[picture]');
            if ($UploadedImage) {
                $FileName = uniqid("IMG_", true) . "." . $UploadedImage->extension;
                $EmergencyContact->setAttribute("ryb_user_emer_cont_pic", $this->uploadUserFileAPI($UploadedImage, $FileName));
            } else {
                $EmergencyContact->setAttribute("ryb_user_emer_cont_pic", $EmergencyContact->ryb_user_emer_cont_pic);
            }
            if ($EmergencyContact->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Emergency contact added!",
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

    public function actionAboutUs() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Content found",
                "task_data" => \app\models\CmAboutusMaster::find()
                        ->select(["ryb_cm_aboutus_text AS text", "ryb_cm_aboutus_file AS file"])
                        ->where(["ryb_cm_aboutus_id" => 1])
                        ->asArray()->one()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionTermCondition() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Content found",
                "task_data" => \app\models\CmTermConditionMaster::find()
                        ->select(["ryb_cm_term_condition_text AS text", "ryb_cm_term_condition_file AS file"])
                        ->where(["ryb_cm_term_condition_id" => 1])
                        ->asArray()->one()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionCancelRefund() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Content found",
                "task_data" => \app\models\CmCancelRefundMaster::find()
                        ->select(["ryb_cm_cancel_refund_text AS text", "ryb_cm_cancel_refund_file AS file"])
                        ->where(["ryb_cm_cancel_refund_id" => 1])
                        ->asArray()->one()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionPrivacyPolicy() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Content found",
                "task_data" => \app\models\CmPrivacyPolicyMaster::find()
                        ->select(["ryb_cm_privacy_policy_text AS text", "ryb_cm_privacy_policy_file AS file"])
                        ->where(["ryb_cm_privacy_policy_id" => 1])
                        ->asArray()->one()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionResetPassword() {
        $this->_validateRequest(['emailid', 'phoneno', 'password']);
        try {
            $User = \app\models\UserMaster::find()
                            ->orWhere([
                                'OR',
                                ["ryb_user_emailid" => $this->RequestData["emailid"]],
                                ["ryb_user_phoneno" => $this->RequestData["phoneno"]]
                            ])->one();
            if ($User) {
                $User->setAttribute("ryb_user_password", \Yii::$app->getSecurity()->generatePasswordHash($this->RequestData["password"]));
                if ($User->save()) {
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Password changed!",
                        "task_data" => []
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($User->errors),
                        "task_data" => []
                    ]);
                }
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Email Id or Phone no.",
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

    public function actionFaq() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: FAQ questions found!",
                "task_data" => \app\models\CmFaqMaster::find()
                        ->select(["ryb_cm_faq_question AS question", "ryb_cm_faq_answer AS answer"])
                        ->where(["ryb_status_id" => 2])
                        ->asArray()->all()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionGetWalletBalance() {
        $this->_validateRequest(['user_id', 'page_no']);
        try {
            $Wallet = \app\models\UserWalletMaster::find()
                    ->select([
                        "ryb_user_wallet_id AS wallet_id",
                        "ryb_user_wallet_balance AS wallet_balance",
                        "ryb_user_wallet_updated_at AS last_updated"
                    ])
                    ->where(["ryb_user_id" => $this->RequestData["user_id"]])
                    ->asArray()
                    ->one();
            if (!$Wallet) {
                $NewWallet = new \app\models\UserWalletMaster();
                $NewWallet->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
                if (!$NewWallet->save()) {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($NewWallet->errors),
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
            }
            $Wallet["last_updated"] = date("h:i A", strtotime($Wallet["last_updated"]));
            $Transaction = array_map(function ($value) {
                $value["transaction_at"] = date("h:m A d-m-Y", strtotime($value["transaction_at"]));
                return $value;
            }, \app\models\UserWalletTransMaster::find()
                            ->select([
                                "ryb_user_wallet_trans_id AS transaction_id", "ryb_user_wallet_trans_code AS transaction_code",
                                "ryb_user_wallet_trans_payment_id AS payment_id", "ryb_user_wallet_trans_remark AS remark",
                                "ryb_user_wallet_trans_type AS type", "ryb_user_wallet_trans_total_amnt AS total_amount",
                                "ryb_user_wallet_trans_status AS status", "ryb_user_wallet_trans_datetime AS transaction_at"
                            ])
                            ->where(["ryb_user_id" => $this->RequestData["user_id"]])
                            ->orderBy("transaction_id DESC")
                            ->asArray()->all());
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Wallet balance!",
                "task_data" => [
                    "Wallet" => $Wallet,
                    "Transaction" => $Transaction
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

    public function actionCreditWallet() {
        $this->_validateRequest(['user_id', 'transaction_amount']);
        try {
            $WalletId = (\app\models\UserWalletMaster::find()->where(["ryb_user_id" => $this->RequestData["user_id"]])->one())->ryb_user_wallet_id;
            $Transaction_Code = strtoupper(substr(uniqid(), 0, 6));
            $Transaction = new \app\models\UserWalletTransMaster();
            $Transaction->setAttribute('ryb_user_id', $this->RequestData["user_id"]);
            $Transaction->setAttribute('ryb_user_wallet_trans_total_amnt', $this->RequestData["transaction_amount"]);
            $Transaction->setAttribute('ryb_user_wallet_trans_amnt', $this->RequestData["transaction_amount"]);
            $Transaction->setAttribute('ryb_user_wallet_id', $WalletId);
            $Transaction->setAttribute('ryb_user_wallet_trans_remark', "Wallet Recharge: $Transaction_Code");
            $Transaction->setAttribute('ryb_user_wallet_trans_category_id', 3);
            $Transaction->setAttribute('ryb_user_wallet_trans_code', $Transaction_Code);
            $Transaction->setAttribute('ryb_user_wallet_trans_type', 1);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.razorpay.com/v1/orders",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => '{"amount":' . $this->RequestData["transaction_amount"] . '00,"currency":"INR","receipt":"' . $Transaction->ryb_user_wallet_trans_remark . '","payment_capture":1,"notes":{}}',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    //"Authorization: Basic cnpwX2xpdmVfV2FYeXI4c200S1h6cko6elQ0RnAxbE5DaVl6bldqaEVhU3JlSGN0",
                    "Authorization: Basic cnpwX3Rlc3RfN1loeVc3MFJ0WTJCaDA6eXEyc093enNBQ0JwU1RNa3YyTUtaejZJ",
                    "Content-Type: text/plain"
                ),
            ));
            $PaymentGatewayResponse = (array) json_decode(curl_exec($curl));
            curl_close($curl);
            $Transaction->setAttribute('ryb_user_wallet_trans_payment_id', $PaymentGatewayResponse["id"]);
            $Transaction->setAttribute('ryb_user_wallet_trans_status', 1);
            if ($Transaction->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Request added",
                    "task_data" => [
                        "transaction_code" => $Transaction->ryb_user_wallet_trans_code,
                        "order_id" => $PaymentGatewayResponse["id"],
                        "payment_gateway" => $PaymentGatewayResponse
                    ]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($Transaction->errors),
                    "task_data" => []
                ]);
            }
            /*
             * rzp_live_WaXyr8sm4KXzrJ
             * zT4Fp1lNCiYznWjhEaSreHct
             */
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionAuthorizeCredit() {
        $this->_validateRequest(['user_id', 'order_id', 'transaction_code', 'transaction_json']);
        try {
            $Transaction = \app\models\UserWalletTransMaster::find()->where([
                        "ryb_user_wallet_trans_code" => $this->RequestData["transaction_code"],
                        "ryb_user_wallet_trans_payment_id" => $this->RequestData["order_id"],
                        "ryb_user_id" => $this->RequestData["user_id"],
                        "ryb_user_wallet_trans_status" => 1
                    ])->one();
            if ($Transaction) {
                $Transaction->setAttribute('ryb_user_wallet_trans_status', 2);
                $Transaction->setAttribute('ryb_user_wallet_trans_json', $this->RequestData["transaction_json"]);
                if ($Transaction->save()) {
                    $Wallet = \app\models\UserWalletMaster::find()->where(["ryb_user_id" => $this->RequestData["user_id"]])->one();
                    $Wallet->setAttribute("ryb_user_wallet_balance", ($Wallet->ryb_user_wallet_balance + $Transaction->ryb_user_wallet_trans_amnt));
                    $Wallet->setAttribute("ryb_user_wallet_updated_at", date("Y-m-d h:i:s"));
                    $Wallet->save();
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Wallet balance updated!",
                        "task_data" => []
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Validation error - " . $this->parseValidationError($Transaction->errors),
                        "task_data" => []
                    ]);
                }
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid TRANSACTION CODE or ORDER ID",
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
        $this->_validateRequest(['user_id', 'pickup_pincode']);
        try {
            $CabTypeIdArray = \app\models\RateCardMaster::find()->select([
                        "DISTINCT ON (ryb_cabtype_id)ryb_cabtype_id", "ryb_rate_card_pr_km"
                    ])->where([
                        "ryb_pincode_master.ryb_pincode_number" => $this->RequestData["pickup_pincode"]
                    ])->joinWith(["rybPincode"])->asArray()->all();
            $CabTypeIdArray = array_map(function ($v) {
                unset($v["rybPincode"]);
                if ($v["ryb_rate_card_pr_km"] == 0) {
                    unset($v["ryb_cabtype_id"]);
                }
                return $v["ryb_cabtype_id"];
            }, $CabTypeIdArray);
            if (count($CabTypeIdArray) > 0) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Data found",
                    "task_data" => [
                        "RideType" => \app\models\RideTypeMaster::find()->select([
                            "ryb_ride_type_id AS ride_type_id",
                            "ryb_ride_type_title AS ride_type_title",
                        ])->orderBy("ride_type_id ASC")->asArray()->all(),
                        "CabType" => array_map(function ($CabType) {
                                    $CabType["cab_type_icon"] = \Yii::$app->request->hostInfo . $CabType["cab_type_icon"];
                                    return $CabType;
                                }, \app\models\CabtypeMaster::find()
                                        ->select([
                                            "ryb_cabtype_id AS cab_type_id",
                                            "ryb_cabtype_title AS cab_type_title",
                                            "ryb_cabtype_icon AS cab_type_icon",
                                            "ryb_cabtype_seating AS cab_type_seating"
                                        ])
                                        ->where(["ryb_status_id" => 2, "ryb_cabtype_id" => array_filter($CabTypeIdArray)])
                                        ->asArray()->all()),
                        "TimeSlot" => \app\models\TimeSlotMaster::find()->select([
                            "ryb_time_slot_id AS time_slot_id",
                            "ryb_time_slot_start AS start_time",
                            "ryb_time_slot_end AS end_time"
                        ])->asArray()->all()
                    ]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Area not serviceable!",
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

    public function actionPaymentMode() {
        $this->_validateRequest(['user_id']);
        try {
            $Wallet = \app\models\UserWalletMaster::find()
                    ->select([
                        "ryb_user_wallet_id AS wallet_id",
                        "ryb_user_wallet_balance AS wallet_balance",
                        "ryb_user_wallet_updated_at AS last_updated"
                    ])
                    ->where(["ryb_user_id" => $this->RequestData["user_id"]])
                    ->asArray()
                    ->one();
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Data found",
                "task_data" => [
                    "PaymentMode" => [
                        ["id" => 1, "name" => "Cash"],
                        ["id" => 2, "name" => "Wallet"]
                    ],
                    "WalletBalance" => (float) ($Wallet ? $Wallet["wallet_balance"] : []),
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

    public function actionFetchConfiguration() {
        /*
         * RETURN BID TIME ACCORDING TO PICKUP PINCODE
         */
        $this->_validateRequest([
            'user_id', 'ride_type_id', 'cab_type_id',
            'time_slot_id', 'pickup_location', 'drop_location',
            'total_estimated_distance', 'total_estimated_time', 'device_time'
        ]);
        try {
            $PickupLocation = (array) json_decode($this->RequestData["pickup_location"]);
            $BidTimeArray = \app\models\BidTimeMaster::find()
                            ->select([
                                "ryb_bid_time_master.ryb_bid_time_id AS bid_time_id",
                                "ryb_bid_time_master.ryb_bid_time_minute AS bid_time_minute"
                            ])
                            ->where([
                                'ryb_pincode_master.ryb_pincode_number' => $PickupLocation["pincode"]
                            ])
                            ->joinWith(["rybPincode"])
                            ->asArray()->all();
            if (count($BidTimeArray) > 0) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Configuration found",
                    "task_data" => [
                        "BidTime" => array_map(function ($Time) {
                                    unset($Time["rybPincode"]);
                                    return $Time;
                                }, $BidTimeArray)
                    ]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Area not serviceable",
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

    public function actionFetchAirport() {
        $this->_validateRequest(["user_id", "pickup_pincode"]);
        try {
            $Pincode = \app\models\PincodeMaster::find()->where(["ryb_pincode_number" => $this->RequestData["pickup_pincode"]])->asArray()->one();
            if ($Pincode) {
                $AirportArray = \app\models\AirportMaster::find()
                                ->select([
                                    "ryb_airport_master.ryb_airport_id AS airport_id", "ryb_airport_master.ryb_airport_name AS airport_name",
                                    "ryb_airport_master.ryb_airport_latitude AS airport_latitude", "ryb_airport_master.ryb_airport_longitude AS airport_longitude"
                                ])
                                ->where(["ryb_airport_city_master.ryb_city_id" => $Pincode["ryb_city_id"]])
                                ->joinWith(["airportCityMasters"])
                                ->asArray()->all();
                if (count($AirportArray) > 0) {
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Area serviceable",
                        "task_data" => array_map(function ($Airport) {
                                    unset($Airport["airportCityMasters"]);
                                    return $Airport;
                                }, $AirportArray)
                    ]);
                }
            }
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: Area not serviceable",
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

    public function actionFetchRentalPackage() {
        $this->_validateRequest(["user_id", "pickup_pincode", "cab_type_id"]);
        try {
            $RentalRateCard = \app\models\RentalRateCardMaster::find()
                    ->select([
                        'ryb_rental_rate_card_1hr AS rental_rate_card_1hr', 'ryb_rental_rate_card_2hr AS rental_rate_card_2hr',
                        'ryb_rental_rate_card_3hr AS rental_rate_card_3hr', 'ryb_rental_rate_card_4hr AS rental_rate_card_4hr',
                        'ryb_rental_rate_card_5hr AS rental_rate_card_5hr', 'ryb_rental_rate_card_6hr AS rental_rate_card_6hr',
                        'ryb_rental_rate_card_7hr AS rental_rate_card_7hr', 'ryb_rental_rate_card_8hr AS rental_rate_card_9hr',
                        'ryb_rental_rate_card_10hr AS rental_rate_card_10hr', 'ryb_rental_rate_card_11hr AS rental_rate_card_11hr',
                        'ryb_rental_rate_card_12hr AS rental_rate_card_12hr'
                    ])
                    ->joinWith(['rybPincode'])
                    ->where([
                        'ryb_pincode_master.ryb_pincode_number' => $this->RequestData["pickup_pincode"],
                        'ryb_cabtype_id' => $this->RequestData["cab_type_id"],
                        'ryb_ride_type_id' => 3
                    ])
                    ->asArray()
                    ->one();
            unset($RentalRateCard["rybPincode"]);
            $RentalRateCardArray = [];
            $RentalExtra = \app\models\RentalPackageMaster::find()
                    ->select([
                        "ryb_rental_package_id AS rental_package_id", "ryb_rental_package_hour AS rental_package_hour",
                        "ryb_rental_package_km_allowed AS rental_package_km_allowed", "ryb_rental_package_km_ext_charge AS rental_package_km_ext_charge",
                        "ryb_rental_package_hr_ext_charge AS rental_package_hr_ext_charge"
                    ])
                    ->where(['ryb_cabtype_id' => $this->RequestData["cab_type_id"]])
                    ->asArray()
                    ->all();
            foreach ($RentalExtra as $key => $value) {
                $RentalRateCardArray[] = array_merge($value, ["rental_package_charges" => $RentalRateCard["rental_rate_card_" . ( ++$key) . "hr"]]);
            }
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Area serviceable",
                "task_data" => $RentalRateCardArray
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionFetchEstimatedPrice() {
        $this->_validateRequest([
            'user_id', 'ride_type_id', 'cab_type_id', 'time_slot_id', 'pickup_location', 'selected_bid_time',
            'drop_location', 'payment_mode', 'total_estimated_distance', 'total_estimated_time', 'selected_hour_rental'
        ]);
        try {
            $PickupLocation = (array) json_decode($this->RequestData["pickup_location"]);
            $ConfPackage = \app\models\ConfPackageMaster::find()
                            ->where([
                                "ryb_pincode_master.ryb_pincode_number" => $PickupLocation["pincode"]
                            ])
                            ->joinWith(["rybPincode"])->asArray()->one();

            if ($ConfPackage) {
                $RydoBidCommission = \app\models\CommPercentMaster::find()->where(["ryb_pincode_id" => $ConfPackage["ryb_pincode_id"]])->asArray()->one();
                $RideModel = new \app\models\UserRideMaster();
                $EstimatedRideFare = 0;
                if ($this->RequestData["ride_type_id"] != 3) {
                    $RateCard = \app\models\RateCardMaster::find()
                                    //->select([])
                                    ->where([
                                        "ryb_pincode_master.ryb_pincode_number" => $PickupLocation["pincode"],
                                        "ryb_rate_card_master.ryb_ride_type_id" => $this->RequestData["ride_type_id"],
                                        "ryb_rate_card_master.ryb_cabtype_id" => $this->RequestData["cab_type_id"],
                                        "ryb_rate_card_master.ryb_time_slot_id" => $this->RequestData["time_slot_id"],
                                    ])
                                    ->joinWith(["rybPincode"])
                                    ->asArray()->one();
                    if (!$RateCard) {
                        $this->_sendResponse(400, [
                            "task_status" => 0,
                            "task_message" => "Error: Area not serviceable",
                            "task_data" => []
                        ]);
                    }
                    $EstimatedRideFare = $EstimatedFare = $RideModel->fetchEstimatedPrice(
                            $RydoBidCommission["ryb_comm_percent_amt"],
                            ($RateCard["ryb_rate_card_pr_km"] * $this->RequestData["total_estimated_distance"] / 1000)
                    );
                } else {
                    $RentalRateCard = \app\models\RentalRateCardMaster::find()
                            ->select([
                                'ryb_rental_rate_card_1hr AS rental_rate_card_1hr', 'ryb_rental_rate_card_2hr AS rental_rate_card_2hr',
                                'ryb_rental_rate_card_3hr AS rental_rate_card_3hr', 'ryb_rental_rate_card_4hr AS rental_rate_card_4hr',
                                'ryb_rental_rate_card_5hr AS rental_rate_card_5hr', 'ryb_rental_rate_card_6hr AS rental_rate_card_6hr',
                                'ryb_rental_rate_card_7hr AS rental_rate_card_7hr', 'ryb_rental_rate_card_8hr AS rental_rate_card_9hr',
                                'ryb_rental_rate_card_10hr AS rental_rate_card_10hr', 'ryb_rental_rate_card_11hr AS rental_rate_card_11hr',
                                'ryb_rental_rate_card_12hr AS rental_rate_card_12hr'
                            ])
                            ->joinWith(['rybPincode'])
                            ->where([
                                'ryb_pincode_master.ryb_pincode_number' => $PickupLocation["pincode"],
                                'ryb_cabtype_id' => $this->RequestData["cab_type_id"],
                                'ryb_ride_type_id' => 3
                            ])
                            ->asArray()
                            ->one();
                    $HourRentalCharge = $RentalRateCard["rental_rate_card_" . $this->RequestData["selected_hour_rental"] . "hr"];
                    if (!$RentalRateCard) {
                        $this->_sendResponse(400, [
                            "task_status" => 0,
                            "task_message" => "Error: Area not serviceable",
                            "task_data" => []
                        ]);
                    }
                    $EstimatedFare = $RideModel->fetchEstimatedPrice($RydoBidCommission["ryb_comm_percent_amt"], $HourRentalCharge);
                }
                $CabType = \app\models\CabtypeMaster::find()->select([
                            "ryb_cabtype_id AS cab_type_id",
                            "ryb_cabtype_title AS cab_type_title",
                            "ryb_cabtype_icon AS cab_type_icon",
                            "ryb_cabtype_seating AS cab_type_seating"
                        ])->where([
                            "ryb_cabtype_id" => $this->RequestData["cab_type_id"]
                        ])->asArray()->one();
                $CabType["cab_type_icon"] = \Yii::$app->request->hostInfo . $CabType["cab_type_icon"];
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Estimated price calculated",
                    "task_data" => [
                        "Ride" => [
                            "EstimatedRideFare" => $EstimatedRideFare,
                            "BidTime" => $this->RequestData["selected_bid_time"],
                            "AcceptanceTime" => $ConfPackage["ryb_conf_package_response_time"],
                            "PickupLocation" => $PickupLocation,
                            "Droplocation" => (array) json_decode($this->RequestData["drop_location"]),
                            "PaymentMode" => ($this->RequestData["payment_mode"] == 1 ? "Cash" : "Wallet")
                        ],
                        "RideType" => \app\models\RideTypeMaster::find()->select([
                            "ryb_ride_type_id AS ride_type_id",
                            "ryb_ride_type_title AS ride_type_title",
                        ])->where([
                            "ryb_ride_type_id" => $this->RequestData["ride_type_id"]
                        ])->asArray()->one(),
                        "CabType" => $CabType
                    ]
                ]);
            }
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: Area not serviceable",
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

    public function actionValidatePromocode() {
        $this->_validateRequest(['user_id', 'promocode', "pickup_pincode", "ride_type_id", "cab_type_id", "estimated_ride_fare"]);
        try {
            $IsPromocodeValid = true;
            $Promocode = \app\models\PromocodeMaster::find()
                            ->where([
                                "ryb_promocode_unique" => $this->RequestData["promocode"],
                                "ryb_status_id" => 2
                            ])
                            ->joinWith(["promocodeCabTypeMasters", "promocodeCityMasters", "promocodeRideTypeMasters"])
                            ->asArray()->one();
            /*
             * STEPS TO VALIDATE PROMO CODE
             * 1) PROMOCODE EXISTS OR NOT
             * 2) PROMOCODE IS USABLE OR NOT
             * 3) PROMOCODE LIES UNDER DATE RANGE OR NOT
             * 4) PROMOCODE LIES UNDER RIDE TYPE ID
             * 5) PROMOCODE LIES UNDER CAB TYPE ID
             * 6) DISCOUNT AMOUNT SHOULD BE LESS THAN MAXIMUM CASHBACK
             * 7) TRANSACTION AMOUNT SHOULD BE MORE THAN MINIMUM TRANSACTION AMOUNT
             */
            if ($Promocode) {
                $DiscountAmount = 0;
                $EstimatedRideFare = $this->RequestData["estimated_ride_fare"];
                if ($Promocode["ryb_promocode_min_trans_amnt"] != 0) {
                    if ($EstimatedRideFare < $Promocode["ryb_promocode_min_trans_amnt"]) {
                        $IsPromocodeValid = false;
                    }
                }

                if ($IsPromocodeValid == true && $Promocode["ryb_promocode_is_date_range"] == 1) {
                    $CurrentDate = date('Y-m-d', strtotime(date("Y-m-d")));
                    $PromoStartDate = date('Y-m-d', strtotime($Promocode["ryb_promocode_date_start"]));
                    $PromoEndDate = date('Y-m-d', strtotime($Promocode["ryb_promocode_date_end"]));
                    if (($CurrentDate >= $PromoStartDate) && ($CurrentDate <= $PromoEndDate)) {
                        $IsPromocodeValid = true;
                    } else {
                        $IsPromocodeValid = false;
                    }
                }
                if ($IsPromocodeValid == true && $Promocode["ryb_promocode_is_ride_type"] == 1) {
                    $RideTypeArray = [];
                    if (count($Promocode["promocodeRideTypeMasters"]) > 0) {
                        $RideTypeArray = array_map(function($v) {
                            return $v["ryb_ride_type_id"];
                        }, $Promocode["promocodeRideTypeMasters"]);
                    }
                    if (!in_array($this->RequestData["ride_type_id"], $RideTypeArray)) {
                        $IsPromocodeValid = false;
                    }
                }
                if ($IsPromocodeValid == true && $Promocode["ryb_promocode_is_cab_type"] == 1) {
                    $CabTypeArray = [];
                    if (count($Promocode["promocodeCabTypeMasters"]) > 0) {
                        $CabTypeArray = array_map(function($v) {
                            return $v["ryb_cabtype_id"];
                        }, $Promocode["promocodeCabTypeMasters"]);
                    }
                    if (!in_array($this->RequestData["cab_type_id"], $CabTypeArray)) {
                        $IsPromocodeValid = false;
                    }
                }
                if ($IsPromocodeValid == true && $Promocode["ryb_promocode_is_city_type"] == 1) {
                    $CityTypeArray = [];
                    if (count($Promocode["promocodeCityMasters"]) > 0) {
                        $CityTypeArray = array_map(function($v) {
                            return $v["ryb_city_id"];
                        }, $Promocode["promocodeCityMasters"]);
                    }
                    if (!in_array($this->RequestData["city_id"], $CityTypeArray)) {
                        $IsPromocodeValid = false;
                    }
                }
                if ($IsPromocodeValid == true) {
                    if ($Promocode["ryb_promocode_disc_type"] == 1) {
                        $DiscountAmount = ($EstimatedRideFare * $Promocode["ryb_promocode_disc_amnt"] / 100);
                    } else {
                        $DiscountAmount = $Promocode["ryb_promocode_disc_amnt"];
                    }
                    if ($DiscountAmount > $Promocode["ryb_promocode_max_disc_amnt"]) {
                        $DiscountAmount = $Promocode["ryb_promocode_max_disc_amnt"];
                    }
                    $UpdatedFare = $this->RequestData["estimated_ride_fare"] - $DiscountAmount;
                    $this->_sendResponse(200, [
                        "task_status" => 1,
                        "task_message" => "Success: Promocode applied",
                        "task_data" => [
                            "PromocodeId" => $Promocode["ryb_promocode_id"],
                            "UpdatedFare" => (float) $UpdatedFare,
                            "DiscountAmount" => (float) $DiscountAmount
                        ]
                    ]);
                } else {
                    $this->_sendResponse(400, [
                        "task_status" => 0,
                        "task_message" => "Error: Invalid Promocode!",
                        "task_data" => []
                    ]);
                }
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Promocode!",
                    "task_data" => []
                ]);
            }
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
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

    public function actionConfirmRide() {
        $this->_validateRequest([
            'user_id', 'ride_type_id', 'cab_type_id', 'time_slot_id', 'pickup_location', 'drop_location', 'payment_mode', 'promocode_id',
            'total_estimated_distance', 'total_estimated_time', 'selected_bid_time', 'selected_hour_rental', 'selected_scheduled_time'
        ]);
        try {
            $PickupLocation = (array) json_decode($this->RequestData["pickup_location"]);
            $DropLocation = (array) json_decode($this->RequestData["drop_location"]);

            $RateCard = \app\models\RateCardMaster::find()
                            ->where([
                                "ryb_pincode_master.ryb_pincode_number" => $PickupLocation["pincode"]
                            ])
                            ->joinWith(["rybPincode"])
                            ->asArray()->one();
            if (!$RateCard) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Error: Area not serviceable",
                    "task_data" => []
                ]);
            }

            $RydoBidCommission = \app\models\CommPercentMaster::find()->where(["ryb_pincode_id" => $RateCard["ryb_pincode_id"]])->asArray()->one();
            $RideModel = new \app\models\UserRideMaster();
            $RideModel->setAttribute("ryb_ride_status_id", 1);
            $RideModel->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
            $RideModel->setAttribute("ryb_ride_type_id", $this->RequestData["ride_type_id"]);
            $RideModel->setAttribute("ryb_cabtype_id", $this->RequestData["cab_type_id"]);
            $RideModel->setAttribute("ryb_time_slot_id", $this->RequestData["time_slot_id"]);
            $RideModel->setAttribute("ryb_pincode_id", $RateCard["ryb_pincode_id"]);
            $RideModel->setAttribute("ryb_user_pickup_pincode", $PickupLocation["pincode"]);
            $RideModel->setAttribute("ryb_user_pickup_location", json_encode($PickupLocation));
            $RideModel->setAttribute("ryb_user_drop_pincode", $DropLocation["pincode"]);
            $RideModel->setAttribute("ryb_user_drop_location", json_encode($DropLocation));
            $RideModel->setAttribute("ryb_user_payment_mode", $this->RequestData["payment_mode"]);
            $RideModel->setAttribute("ryb_user_ride_est_dist", $this->RequestData["total_estimated_distance"]);
            $RideModel->setAttribute("ryb_user_ride_est_time", $this->RequestData["total_estimated_time"]);
            $RideModel->setAttribute("ryb_user_ride_bid_time", $this->RequestData["selected_bid_time"]);
            $RideModel->setAttribute("ryb_user_ride_booking_id", "RYD-" . $this->generateRandomString(8));
            $RideModel->setAttribute("ryb_user_ride_otp", "123456");
            $EstimatedFare = 0;
            if ($this->RequestData["ride_type_id"] == 3) {
                $RideModel->setAttribute("ryb_user_ride_hour_rental", $this->RequestData["selected_hour_rental"]);
                $RentalRate = \app\models\RentalRateCardMaster::find()->where([
                            "ryb_pincode_id" => $RateCard["ryb_pincode_id"],
                            "ryb_cabtype_id" => $this->RequestData["cab_type_id"],
                            "ryb_ride_type_id" => 3
                        ])->asArray()->one();
                $EstimatedFare = $RideModel->fetchEstimatedPrice(
                        $RydoBidCommission["ryb_comm_percent_amt"],
                        ($RentalRate["ryb_rental_rate_card_" . $this->RequestData["selected_hour_rental"] . "hr"])
                );
            } else {
                $EstimatedFare = $RideModel->fetchEstimatedPrice(
                        $RydoBidCommission["ryb_comm_percent_amt"],
                        ($RateCard["ryb_rate_card_pr_km"] * ($this->RequestData["total_estimated_distance"] / 1000))
                );
            }
            $RideModel->setAttribute("ryb_user_ride_est_fare", $EstimatedFare);
            if ($this->RequestData["selected_scheduled_time"]) {
                $RideModel->setAttribute("ryb_user_ride_is_scheduled", true);
                $RideModel->setAttribute("ryb_user_ride_sch_datetime", date("Y-m-d H:i:s", strtotime($this->RequestData["selected_scheduled_time"])));
            }
            if ($RideModel->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Booking confirmed",
                    "task_data" => ["BookingId" => $RideModel->ryb_user_ride_booking_id]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($RideModel->errors),
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

    public function actionGetAllBid() {
        $this->_validateRequest(['user_id', 'booking_id']);
        try {


            /* $BidExistRide = \app\models\UserRideBidMaster::find()
              ->where([
              //"ryb_user_ride_bid_master.ryb_user_ride_bid_id" => $this->RequestData["bid_id"],
              "ryb_user_ride_bid_master.ryb_user_ride_bid_status" => 2,
              "ryb_user_ride_master.ryb_user_ride_booking_id" => $this->RequestData["booking_id"]
              ])
              ->joinWith(["rybUserRide"])
              ->one();
              if ($BidExistRide) {
              $this->_sendResponse(400, [
              "task_status" => 0,
              "task_message" => "Error: Bidding closed, No active bids found!",
              "task_data" => []
              ]);
              } */


            $BidArray = \app\models\UserRideBidMaster::find()
                    ->select([
                        "ryb_user_ride_bid_id AS bid_id", "ryb_user_ride_bid_price AS bid_price",
                        "ryb_user_ride_bid_eta AS bid_eta", "ryb_user_ride_bid_added_at AS bid_added_at",
                        "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id"
                    ])
                    ->where([
                        #"ryb_user_ride_master.ryb_user_ride_booking_id" => $this->RequestData["booking_id"],
                        "ryb_user_ride_bid_master.ryb_user_id" => $this->RequestData["user_id"],
                        "ryb_user_ride_master.ryb_ride_status_id" => 3
                    ])
                    ->joinWith(["rybDriver", "rybUserRide"])
                    ->orderBy("ryb_user_ride_master.ryb_user_ride_id DESC")
                    ->asArray()
                    ->all();
            if (count($BidArray) > 0) {
                $ResponseArray = [];
                foreach ($BidArray as $key => $value) {
                    $value["bid_added_at"] = date("h:i A d-m-Y", strtotime($value["bid_added_at"]));
                    $value["driver_name"] = "Sample Driver 0" . ( ++$key);
                    $value["cab_name"] = ((( ++$key) % 2 == 0) ? "Honda City 2011" : "Maruti Suzuki WagonR");
                    $value["driver_picture"] = "https://rydobid.xyz/web/images/app-icon.png";
                    $ResponseArray[] = array_filter($value);
                }
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Bid List found",
                    "task_data" => $ResponseArray
                ]);
            } else {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Error: No bids found!",
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

    public function actionAcceptBid() {
        $this->_validateRequest(['user_id', 'booking_id', 'bid_id']);
        try {

            //Yii::$app->db->createCommand("UPDATE ryb_user_ride_bid_master SET ryb_user_ride_bid_status = 1;")->execute();

            $BidExistRide = \app\models\UserRideBidMaster::find()
                    ->where([
                        //"ryb_user_ride_bid_master.ryb_user_ride_bid_id" => $this->RequestData["bid_id"],
                        "ryb_user_ride_bid_master.ryb_user_ride_bid_status" => 2,
                        "ryb_user_ride_master.ryb_user_ride_booking_id" => $this->RequestData["booking_id"]
                    ])
                    ->joinWith(["rybUserRide"])
                    ->one();
            if ($BidExistRide) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Booking Bid already confirmed",
                    "task_data" => []
                ]);
            }

            $BidRideModel = \app\models\UserRideBidMaster::find()
                    ->where([
                        "ryb_user_ride_bid_id" => $this->RequestData["bid_id"],
                        "ryb_user_ride_bid_status" => 1
                    ])
                    ->joinWith(["rybUserRide"])
                    ->one();
            if (!$BidRideModel) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Bid!",
                    "task_data" => []
                ]);
            }
            $BidRideModel->setAttribute("ryb_user_ride_bid_status", 2);
            if ($BidRideModel->save()) {
                $Ride = \app\models\UserRideMaster::find()->where([
                            "ryb_user_ride_booking_id" => $BidRideModel->rybUserRide->ryb_user_ride_booking_id
                        ])->one();
                $Ride->setAttribute("ryb_ride_status_id", 4);
                //$Ride->setAttribute("ryb_ride_status_id", 3);
                $Ride->save(false);
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Bid confirmed",
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

    public function actionConfirmedBid() {
        $this->_validateRequest(['user_id', 'booking_id']);
        try {
            $ConfirmedBid = \app\models\UserRideBidMaster::find()
                            ->select([
                                "ryb_user_ride_master.ryb_user_ride_id AS ride_id", "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                                "ryb_user_ride_master.ryb_user_pickup_pincode AS pickup_location", "ryb_user_ride_master.ryb_user_drop_pincode AS drop_location",
                                "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location", "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                                "ryb_user_ride_master.ryb_user_payment_mode AS payment_mode", "ryb_user_ride_master.ryb_user_ride_registered_at AS ride_added_at",
                                "ryb_user_ride_master.ryb_user_ride_est_fare AS ride_fare", "ryb_driver_master.ryb_driver_id AS driver_id",
                                "ryb_cabtype_master.ryb_cabtype_title AS cab_type_title", "ryb_ride_type_master.ryb_ride_type_title AS ride_type_title"
                            ])
                            ->where([
                                "ryb_user_ride_bid_master.ryb_user_ride_bid_status" => 2,
                                "ryb_user_ride_master.ryb_user_ride_booking_id" => $this->RequestData["booking_id"]
                            ])
                            ->joinWith(["rybUserRide", "rybDriver", "rybUserRide.rybCabtype", "rybUserRide.rybRideType"])
                            ->asArray()->one();
            if ($ConfirmedBid) {
                $ConfirmedBid["ride_otp"] = "123456";
                $ConfirmedBid["pickup_full_location"] = (array) json_decode($ConfirmedBid["pickup_full_location"]);
                $ConfirmedBid["drop_full_location"] = (array) json_decode($ConfirmedBid["drop_full_location"]);

                $ConfirmedBid["driver_name"] = "Sample Driver 0" . mt_rand(1, 9);
                $ConfirmedBid["driver_picture"] = "https://rydobid.xyz/web/images/app-icon.png";
                $ConfirmedBid["driver_rating"] = "3.5";
                $ConfirmedBid["driver_contact_no"] = "9876543210";
                $ConfirmedBid["cab_name"] = (((mt_rand(1, 9)) % 2 == 0) ? "Honda City 2011" : "Maruti Suzuki WagonR");
                $ConfirmedBid["cab_reg_no"] = "UP-32-HN-7414";

                $ConfirmedBid["ride_added_at"] = date("h:i A d-m-Y", strtotime($ConfirmedBid["ride_added_at"]));
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Confirmed bid found",
                    "task_data" => array_filter($ConfirmedBid)
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Ride or Bid not confirmed!",
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

    public function actionOnGoingRide() {
        $this->_validateRequest(['user_id', 'booking_id']);
        try {
            $Ride = \app\models\UserRideMaster::find()
                    ->select([
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id", "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_ride_master.ryb_user_payment_mode AS payment_mode", "ryb_user_ride_master.ryb_user_ride_est_fare AS ride_fare",
                        "ryb_user_ride_master.ryb_user_ride_est_time AS ride_eta", "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location", "ryb_user_ride_master.ryb_user_ride_registered_at AS ride_booked_at"
                    ])
                    ->where([
                        "ryb_user_id" => $this->RequestData["user_id"],
                        //"ryb_user_ride_booking_id" => $this->RequestData["booking_id"],
                        "ryb_ride_status_id" => 4
                    ])
                    ->joinWith(["rybCabtype", "rybRideType", "rybTimeSlot"])
                    ->orderBy("ryb_user_ride_master.ryb_user_ride_id DESC")
                    ->asArray()
                    ->one();
            if ($Ride) {
                $Ride["ride_otp"] = "123456";
                $Ride["pickup_full_location"] = (array) json_decode($Ride["pickup_full_location"]);
                $Ride["drop_full_location"] = (array) json_decode($Ride["drop_full_location"]);
                $Ride["ride_booked_at"] = date("h:i A d-m-Y", strtotime($Ride["ride_booked_at"]));
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: 1 On-going ride found",
                    "task_data" => [
                        "Ride" => array_filter($Ride),
                        "Driver" => [
                            "driver_name" => "Sample Driver 0" . mt_rand(1, 9),
                            "driver_picture" => "https://rydobid.xyz/web/images/app-icon.png",
                            "driver_rating" => "3.5",
                            "driver_contact_no" => "9876543210",
                            "cab_name" => (((mt_rand(1, 9)) % 2 == 0) ? "Honda City 2011" : "Maruti Suzuki WagonR"),
                            "cab_reg_no" => "UP-32-HN-7414",
                            "driver_location" => ["latitude" => "26.8127", "longitude" => "80.9013"]
                        ]
                    ]
                ]);
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

    public function actionCancelRide() {
        $this->_validateRequest(['user_id', 'booking_id']);
        try {
            $Ride = \app\models\UserRideMaster::find()
                    ->where([
                        "ryb_user_id" => $this->RequestData["user_id"],
                        "ryb_user_ride_booking_id" => $this->RequestData["booking_id"],
                    ])
                    ->andWhere(['IN', 'ryb_ride_status_id', [1, 3]])
                    ->one();
            if (!$Ride) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Invalid Ride!",
                    "task_data" => []
                ]);
            }
            $Ride->setAttribute("ryb_ride_status_id", 2);
            if ($Ride->save()) {
                $PenaltyAmount = \app\models\PenaltyAmntMaster::find()->where([
                            "ryb_pincode_id" => $Ride->ryb_pincode_id, "ryb_ride_type_id" => $Ride->ryb_ride_type_id
                        ])->asArray()->one();
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Booking cancelled, Penalty Amount applicable!",
                    "task_data" => ["penalty_amount" => $PenaltyAmount["ryb_penalty_amnt"]]
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($Ride->errors),
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

    public function actionGetAllRide() {
        $this->_validateRequest(['user_id', 'page_no']);
        try {
            $RideArray = \app\models\UserRideMaster::find()
                    ->select([
                        "ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_registered_at AS ride_booked_at"
                    ])
                    ->where(["ryb_user_id" => $this->RequestData["user_id"]])
                    ->orderBy("ryb_user_ride_id DESC")
                    ->asArray()
                    ->all();
            if (count($RideArray) > 0) {
                $ResponseArray = [];
                foreach ($RideArray as $key => $value) {
                    $value["pickup_full_location"] = ((array) json_decode($value["pickup_full_location"]))["location"];
                    $value["drop_full_location"] = ((array) json_decode($value["drop_full_location"]))["location"];
                    $value["ride_total_amount"] = 267;
                    $value["ride_booked_at"] = date("h:i A d-m-Y", strtotime($value["ride_booked_at"]));

                    $value["driver_name"] = "Sample Driver 0" . ( ++$key);
                    $value["driver_picture"] = "https://rydobid.xyz/web/images/app-icon.png";

                    $value["cab_name"] = ((( ++$key) % 2 == 0) ? "Honda City 2011" : "Maruti Suzuki WagonR");
                    $value["cab_reg_no"] = "UP-32-HN-7414";

                    $ResponseArray[] = array_filter($value);
                }
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride List found",
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

    public function actionRateRide() {
        $this->_validateRequest(['user_id', 'ride_id', 'driver_id', 'rating_no']);
        try {
            if (\app\models\UserRideRatingMaster::find()->where(["ryb_user_ride_id" => $this->RequestData["ride_id"]])->one()) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Ride already rated!",
                    "task_data" => []
                ]);
            }
            $RideRating = new \app\models\UserRideRatingMaster();
            $RideRating->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
            $RideRating->setAttribute("ryb_user_ride_id", $this->RequestData["ride_id"]);
            $RideRating->setAttribute("ryb_driver_id", $this->RequestData["driver_id"]);
            $RideRating->setAttribute("ryb_user_ride_rating_no", $this->RequestData["rating_no"]);
            if ($RideRating->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride rated!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($RideRating->errors),
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

    public function actionRideSummary() {
        $this->_validateRequest(['user_id', 'booking_id']);
        try {
            $Ride = \app\models\UserRideMaster::find()
                    ->select([
                        "ryb_user_ride_master.ryb_user_ride_id AS ride_id",
                        "ryb_user_ride_master.ryb_user_ride_booking_id AS booking_id",
                        "ryb_user_ride_master.ryb_user_pickup_location AS pickup_full_location",
                        "ryb_user_ride_master.ryb_user_payment_mode AS payment_mode",
                        "ryb_user_ride_master.ryb_user_drop_location AS drop_full_location",
                        "ryb_user_ride_master.ryb_user_ride_registered_at AS ride_booked_at",
                        "ryb_cabtype_master.ryb_cabtype_title",
                        "ryb_ride_type_master.ryb_ride_type_title",
                    ])
                    ->where([
                        "ryb_user_ride_master.ryb_user_id" => $this->RequestData["user_id"],
                        "ryb_user_ride_master.ryb_user_ride_booking_id" => $this->RequestData["booking_id"],
                    ])
                    ->joinWith(["rybCabtype", "rybRideType"])
                    ->asArray()
                    ->one();
            if ($Ride) {
                $Ride["pickup_full_location"] = (array) json_decode($Ride["pickup_full_location"]);
                $Ride["drop_full_location"] = (array) json_decode($Ride["drop_full_location"]);
                $Ride["ride_total_distance"] = 16.3;
                $Ride["ride_total_duration"] = 38;
                $Ride["ride_total_amount"] = 267;
                $Ride["ride_rating"] = 2.5;
                $Ride["ride_booked_at"] = date("h:i A d-m-Y", strtotime($Ride["ride_booked_at"]));

                $Ride["driver_id"] = 1;
                $Ride["driver_name"] = "Sample Driver 0" . mt_rand(1, 9);
                $Ride["driver_picture"] = "https://rydobid.xyz/web/images/app-icon.png";

                $Ride["cab_name"] = ((mt_rand(1, 9) % 2 == 0) ? "Honda City 2011" : "Maruti Suzuki WagonR");
                $Ride["cab_reg_no"] = "UP-32-HN-7414";
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ride found",
                    "task_data" => array_filter($Ride)
                ]);
            } else {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Error: Invalid booking!",
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

    public function actionTicketCategory() {
        $this->_validateRequest(['user_id']);
        try {
            $this->_sendResponse(200, [
                "task_status" => 1,
                "task_message" => "Success: Ticket category found!",
                "task_data" => \app\models\TicketCategoryMaster::find()
                        ->select([
                            "ryb_ticket_category_id AS ticket_category_id",
                            "ryb_ticket_category_text AS ticket_category_text"
                        ])
                        ->asArray()
                        ->all()
            ]);
        } catch (ErrorException $e) {
            $this->_sendResponse(400, [
                "task_status" => 0,
                "task_message" => "Error: {$e->getMessage()}",
                "task_data" => []
            ]);
        }
    }

    public function actionTicketList() {
        $this->_validateRequest(['user_id']);
        try {
            $TicketArray = \app\models\UserTicketMaster::find()
                    ->select([
                        "ryb_user_ticket_id AS ticket_id",
                        "ryb_user_ticket_title AS ticket_title",
                        "ryb_user_ticket_code AS ticket_code",
                        "ryb_user_ticket_priority AS ticket_priority",
                        "ryb_user_ticket_status AS ticket_status",
                        "ryb_user_ticket_added_at AS ticket_added_at"
                    ])
                    ->where([
                        'ryb_user_id' => $this->RequestData["user_id"]
                    ])
                    ->asArray()
                    ->all();
            if (count($TicketArray) > 0) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Tickets found!",
                    "task_data" => array_map(function ($v) {
                                $v["ticket_added_at"] = date("h:i A d-m-Y", strtotime($v["ticket_added_at"]));
                                return $v;
                            }, $TicketArray)
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: No ticket found!",
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

    public function actionTicketCreate() {
        $this->_validateRequest(['user_id', 'ride_id', 'ticket_category_id', 'ticket_priority', 'ticket_title', 'ticket_message']);
        try {
            $Ticket = new \app\models\UserTicketMaster();
            $Ticket->setAttribute('ryb_user_id', $this->RequestData["user_id"]);
            $Ticket->setAttribute('ryb_user_ride_id', $this->RequestData["ride_id"]);
            $Ticket->setAttribute('ryb_ticket_category_id', $this->RequestData["ticket_category_id"]);
            $Ticket->setAttribute('ryb_user_ticket_title', $this->RequestData["ticket_title"]);
            $Ticket->setAttribute('ryb_user_ticket_code', 'TK' . $this->generateRandomString(6));
            $Ticket->setAttribute('ryb_user_ticket_priority', $this->RequestData["ticket_priority"]);
            $Ticket->setAttribute('ryb_user_ticket_status', 1);
            if ($Ticket->save()) {
                $TicketMessage = new \app\models\UserTicketMessage();
                $TicketMessage->setAttribute("ryb_user_ticket_id", $Ticket->ryb_user_ticket_id);
                $TicketMessage->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
                $TicketMessage->setAttribute("ryb_user_ticket_message_text", $this->RequestData["ticket_message"]);
                $TicketMessage->save();
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ticket created!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($Ticket->errors),
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

    public function actionGetTicketThread() {
        $this->_validateRequest(['user_id', 'ticket_id']);
        try {
            $TicketThreadArray = \app\models\UserTicketMessage::find()
                    ->select([
                        "ryb_user_ticket_message.ryb_user_ticket_message_id AS ticket_message_id",
                        "ryb_user_ticket_message.ryb_user_id AS user_id",
                        "ryb_user_ticket_message.ryb_user_ticket_message_text AS ticket_message"
                    ])
                    ->where([
                        "ryb_user_ticket_message.ryb_user_ticket_id" => $this->RequestData["ticket_id"],
                        "ryb_user_ticket_message.ryb_user_id" => $this->RequestData["user_id"],
                    ])
                    ->asArray()
                    ->all();
            if (count($TicketThreadArray) > 0) {
                $Ticket = \app\models\UserTicketMaster::find()
                        ->select([
                            "ryb_user_ticket_id AS ticket_id",
                            "ryb_user_ticket_title AS ticket_title",
                            "ryb_user_ticket_code AS ticket_code",
                            "ryb_user_ticket_priority AS ticket_priority",
                            "ryb_user_ticket_status AS ticket_status",
                            "ryb_user_ticket_added_at AS ticket_added_at"
                        ])
                        ->where([
                            'ryb_user_id' => $this->RequestData["user_id"],
                            'ryb_user_ticket_id' => $this->RequestData["ticket_id"],
                        ])
                        ->asArray()
                        ->one();
                $Ticket["ticket_added_at"] = date("h:i A d-m-Y", strtotime($Ticket["ticket_added_at"]));
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Ticket created!",
                    "task_data" => [
                        "Ticket" => $Ticket,
                        "MessageThread" => $TicketThreadArray
                    ]
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

    public function actionTicketAddMessage() {
        $this->_validateRequest(['user_id', 'ticket_id', 'ticket_message']);
        try {
            $TicketMessage = new \app\models\UserTicketMessage();
            $TicketMessage->setAttribute("ryb_user_ticket_id", $this->RequestData["ticket_id"]);
            $TicketMessage->setAttribute("ryb_user_id", $this->RequestData["user_id"]);
            $TicketMessage->setAttribute("ryb_user_ticket_message_text", $this->RequestData["ticket_message"]);
            if ($TicketMessage->save()) {
                $this->_sendResponse(200, [
                    "task_status" => 1,
                    "task_message" => "Success: Message sent!",
                    "task_data" => []
                ]);
            } else {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: Validation error - " . $this->parseValidationError($TicketMessage->errors),
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
