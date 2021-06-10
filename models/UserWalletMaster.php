<?php

namespace app\models;

use Yii;

class UserWalletMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_wallet_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_id'], 'integer'],
            [['ryb_user_id'], 'required'],
            [['ryb_user_wallet_updated_at'], 'safe'],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_wallet_id' => 'Wallet ID',
            'ryb_user_id' => 'User',
            'ryb_user_wallet_balance' => 'Wallet Balance',
            'ryb_user_wallet_updated_at' => 'Last Updated',
        ];
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function creditWallet() {
        
    }

    public function debitWallet() {
        
    }

}
