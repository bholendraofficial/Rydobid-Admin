<?php

namespace app\models;

use Yii;

class UserRideMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ride_master}}';
    }

    public function rules() {
        return [
            [['ryb_ride_status_id', 'ryb_user_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id', 'ryb_time_slot_id', 'ryb_user_payment_mode', 'ryb_user_ride_hour_rental'], 'default', 'value' => null],
            [['ryb_ride_status_id', 'ryb_user_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id', 'ryb_time_slot_id', 'ryb_user_payment_mode', 'ryb_user_ride_hour_rental'], 'integer'],
            [['ryb_user_pickup_location', 'ryb_user_drop_location'], 'string'],
            [['ryb_user_pickup_pincode', 'ryb_user_drop_pincode', 'ryb_user_ride_est_dist', 'ryb_user_ride_est_time', 'ryb_user_ride_bid_time', 'ryb_user_ride_est_fare'], 'number'],
            [['ryb_user_ride_is_scheduled'], 'boolean'],
            [['ryb_user_ride_sch_datetime', 'ryb_user_ride_registered_at'], 'safe'],
            [['ryb_cabtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => CabtypeMaster::className(), 'targetAttribute' => ['ryb_cabtype_id' => 'ryb_cabtype_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_ride_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideStatusMaster::className(), 'targetAttribute' => ['ryb_ride_status_id' => 'ryb_ride_status_id']],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
            [['ryb_time_slot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TimeSlotMaster::className(), 'targetAttribute' => ['ryb_time_slot_id' => 'ryb_time_slot_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ride_id' => 'Ryb User Ride ID',
            'ryb_ride_status_id' => 'Ryb Ride Status ID',
            'ryb_user_id' => 'Ryb User ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_ride_type_id' => 'Ryb Ride Type ID',
            'ryb_cabtype_id' => 'Ryb Cabtype ID',
            'ryb_time_slot_id' => 'Ryb Time Slot ID',
            'ryb_user_pickup_pincode' => 'Ryb User Pickup Pincode',
            'ryb_user_pickup_location' => 'Ryb User Pickup Location',
            'ryb_user_drop_pincode' => 'Ryb User Drop Pincode',
            'ryb_user_drop_location' => 'Ryb User Drop Location',
            'ryb_user_payment_mode' => 'Ryb User Payment Mode',
            'ryb_user_ride_est_dist' => 'Ryb User Ride Est Dist',
            'ryb_user_ride_est_time' => 'Ryb User Ride Est Time',
            'ryb_user_ride_bid_time' => 'Ryb User Ride Bid Time',
            'ryb_user_ride_est_fare' => 'Ryb User Ride Est Fare',
            'ryb_user_ride_hour_rental' => 'Ryb User Ride Hour Rental',
            'ryb_user_ride_is_scheduled' => 'Ryb User Ride Is Scheduled',
            'ryb_user_ride_sch_datetime' => 'Ryb User Ride Sch Datetime',
            'ryb_user_ride_registered_at' => 'Ryb User Ride Registered At',
            'ryb_user_ride_booking_id' => 'Booking ID',
        ];
    }

    public function getRybCabtype() {
        return $this->hasOne(CabtypeMaster::className(), ['ryb_cabtype_id' => 'ryb_cabtype_id']);
    }

    public function getRybPincode() {
        return $this->hasOne(PincodeMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
    }

    public function getRybRideStatus() {
        return $this->hasOne(RideStatusMaster::className(), ['ryb_ride_status_id' => 'ryb_ride_status_id']);
    }

    public function getRybRideType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

    public function getRybTimeSlot() {
        return $this->hasOne(TimeSlotMaster::className(), ['ryb_time_slot_id' => 'ryb_time_slot_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function fetchEstimatedPrice($processingFee, $estimatedFare) {
        $totalEstimatedFare = ($estimatedFare + (($estimatedFare * $processingFee) / 100));
        $taxPercentage = (TaxMaster::findOne(3))->ryb_tax_percentage;
        return round($totalEstimatedFare + (($totalEstimatedFare * $taxPercentage) / 100));
    }

}
