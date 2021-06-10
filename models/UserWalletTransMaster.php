<?php

namespace app\models;

use Yii;

class UserWalletTransMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_wallet_trans_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_wallet_id', 'ryb_user_id', 'ryb_promocode_id', 'ryb_user_wallet_trans_category_id', 'ryb_user_wallet_trans_type', 'ryb_user_wallet_trans_status'], 'default', 'value' => null],
            [['ryb_user_wallet_id', 'ryb_user_id', 'ryb_promocode_id', 'ryb_user_wallet_trans_category_id', 'ryb_user_wallet_trans_type', 'ryb_user_wallet_trans_status'], 'integer'],
            [['ryb_user_wallet_trans_payment_id', 'ryb_user_wallet_trans_remark', 'ryb_user_wallet_trans_json'], 'string'],
            [['ryb_user_wallet_trans_amnt', 'ryb_user_wallet_trans_tax_amnt', 'ryb_user_wallet_trans_disc_amnt', 'ryb_user_wallet_trans_commi_amnt', 'ryb_user_wallet_trans_driver_amnt', 'ryb_user_wallet_trans_total_amnt'], 'number'],
            [['ryb_user_wallet_trans_datetime'], 'safe'],
            [['ryb_user_wallet_trans_code'], 'string', 'max' => 10],
            [['ryb_promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromocodeMaster::className(), 'targetAttribute' => ['ryb_promocode_id' => 'ryb_promocode_id']],
            [['ryb_user_wallet_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserWalletMaster::className(), 'targetAttribute' => ['ryb_user_wallet_id' => 'ryb_user_wallet_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_wallet_trans_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserWalletTransCategory::className(), 'targetAttribute' => ['ryb_user_wallet_trans_category_id' => 'ryb_user_wallet_trans_category_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_wallet_trans_id' => 'Ryb User Wallet Trans ID',
            'ryb_user_wallet_id' => 'Wallet',
            'ryb_user_id' => 'User',
            'ryb_promocode_id' => 'Promocode',
            'ryb_user_wallet_trans_category_id' => 'Transaction Category',
            'ryb_user_wallet_trans_code' => 'Transaction Code',
            'ryb_user_wallet_trans_payment_id' => 'Payment ID',
            'ryb_user_wallet_trans_type' => 'Transaction Type',
            'ryb_user_wallet_trans_remark' => 'Remark',
            'ryb_user_wallet_trans_amnt' => 'Amount',
            'ryb_user_wallet_trans_tax_amnt' => 'Tax Amount',
            'ryb_user_wallet_trans_disc_amnt' => 'Discount Amount',
            'ryb_user_wallet_trans_commi_amnt' => 'Commission Amount',
            'ryb_user_wallet_trans_driver_amnt' => 'Driver Amount',
            'ryb_user_wallet_trans_total_amnt' => 'Total Amount',
            'ryb_user_wallet_trans_json' => 'Response JSON',
            'ryb_user_wallet_trans_datetime' => 'Transaction At',
            'ryb_user_wallet_trans_status' => 'Transaction Status',
        ];
    }

    public function getRybPromocode() {
        return $this->hasOne(PromocodeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

    public function getRybUserWallet() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_wallet_id' => 'ryb_user_wallet_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybUserWalletTransCategory() {
        return $this->hasOne(UserWalletTransCategory::className(), ['ryb_user_wallet_trans_category_id' => 'ryb_user_wallet_trans_category_id']);
    }

}
