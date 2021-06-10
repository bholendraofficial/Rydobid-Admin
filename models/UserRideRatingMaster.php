<?php

namespace app\models;

use Yii;

class UserRideRatingMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ride_rating_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_ride_id', 'ryb_driver_id', 'ryb_user_id'], 'default', 'value' => null],
            [['ryb_user_ride_id', 'ryb_driver_id', 'ryb_user_id'], 'integer'],
            [['ryb_user_ride_id', 'ryb_driver_id', 'ryb_user_id', 'ryb_user_ride_rating_no'], 'required'],
            [['ryb_user_ride_rating_no'], 'number'],
            [['ryb_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriverMaster::className(), 'targetAttribute' => ['ryb_driver_id' => 'ryb_driver_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_ride_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRideMaster::className(), 'targetAttribute' => ['ryb_user_ride_id' => 'ryb_user_ride_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ride_rating_id' => 'Ride Rating ID',
            'ryb_user_ride_id' => 'Ride',
            'ryb_driver_id' => 'Driver',
            'ryb_user_id' => 'User',
            'ryb_user_ride_rating_no' => 'Rating',
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
