<?php

namespace app\models;

use Yii;

class UserRideTransMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ride_trans_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ryb_user_ride_bid_id', 'ryb_user_ride_id', 'ryb_user_id', 'ryb_promocode_id', 'ryb_user_ride_trans_status'], 'default', 'value' => null],
            [['ryb_user_ride_bid_id', 'ryb_user_ride_id', 'ryb_user_id', 'ryb_promocode_id', 'ryb_user_ride_trans_status'], 'integer'],
            [['ryb_user_ride_fare', 'ryb_user_ride_processing_fee', 'ryb_user_ride_discount_amnt', 'ryb_user_ride_tax_amount', 'ryb_user_ride_total_amount', 'ryb_user_ride_duration', 'ryb_user_ride_distance'], 'number'],
            [['ryb_promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromocodeMaster::className(), 'targetAttribute' => ['ryb_promocode_id' => 'ryb_promocode_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_ride_bid_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRideBidMaster::className(), 'targetAttribute' => ['ryb_user_ride_bid_id' => 'ryb_user_ride_bid_id']],
            [['ryb_user_ride_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRideMaster::className(), 'targetAttribute' => ['ryb_user_ride_id' => 'ryb_user_ride_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ride_trans_id' => 'Ryb User Ride Trans ID',
            'ryb_user_ride_bid_id' => 'Ryb User Ride Bid ID',
            'ryb_user_ride_id' => 'Ryb User Ride ID',
            'ryb_user_id' => 'Ryb User ID',
            'ryb_promocode_id' => 'Ryb Promocode ID',
            'ryb_user_ride_trans_status' => 'Ryb User Ride Trans Status',
            'ryb_user_ride_fare' => 'Ryb User Ride Fare',
            'ryb_user_ride_processing_fee' => 'Ryb User Ride Processing Fee',
            'ryb_user_ride_discount_amnt' => 'Ryb User Ride Discount Amnt',
            'ryb_user_ride_tax_amount' => 'Ryb User Ride Tax Amount',
            'ryb_user_ride_total_amount' => 'Ryb User Ride Total Amount',
            'ryb_user_ride_duration' => 'Ryb User Ride Duration',
            'ryb_user_ride_distance' => 'Ryb User Ride Distance',
        ];
    }

    public function getRybPromocode() {
        return $this->hasOne(PromocodeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybUserRideBid() {
        return $this->hasOne(UserRideBidMaster::className(), ['ryb_user_ride_bid_id' => 'ryb_user_ride_bid_id']);
    }

    public function getRybUserRide() {
        return $this->hasOne(UserRideMaster::className(), ['ryb_user_ride_id' => 'ryb_user_ride_id']);
    }

}
