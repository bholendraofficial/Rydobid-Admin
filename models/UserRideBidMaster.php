<?php

namespace app\models;

use Yii;

class UserRideBidMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ride_bid_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_id', 'ryb_user_ride_id', 'ryb_driver_id', 'ryb_user_ride_bid_status'], 'default', 'value' => null],
            [['ryb_user_id', 'ryb_user_ride_id', 'ryb_driver_id', 'ryb_user_ride_bid_status'], 'integer'],
            [['ryb_user_ride_bid_price', 'ryb_user_ride_bid_eta'], 'number'],
            [['ryb_user_ride_bid_added_at'], 'safe'],
            [['ryb_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriverMaster::className(), 'targetAttribute' => ['ryb_driver_id' => 'ryb_driver_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_ride_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRideMaster::className(), 'targetAttribute' => ['ryb_user_ride_id' => 'ryb_user_ride_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ride_bid_id' => 'Ryb User Ride Bid ID',
            'ryb_user_id' => 'Ryb User ID',
            'ryb_user_ride_id' => 'Ryb User Ride ID',
            'ryb_driver_id' => 'Ryb Driver ID',
            'ryb_user_ride_bid_price' => 'Ryb User Ride Bid Price',
            'ryb_user_ride_bid_eta' => 'Ryb User Ride Bid Eta',
            'ryb_user_ride_bid_status' => 'Ryb User Ride Bid Status',
            'ryb_user_ride_bid_added_at' => 'Ryb User Ride Bid Added At',
        ];
    }

    public function getRybDriver() {
        return $this->hasOne(DriverMaster::className(), ['ryb_driver_id' => 'ryb_driver_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybUserRide() {
        return $this->hasOne(UserRideMaster::className(), ['ryb_user_ride_id' => 'ryb_user_ride_id']);
    }

}
