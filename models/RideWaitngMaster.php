<?php

namespace app\models;

use Yii;

class RideWaitngMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%ride_waitng_master}}';
    }

    public function rules() {
        return [
            [['ryb_ride_type_id', 'ryb_ride_waitng_time'], 'default', 'value' => null],
            [['ryb_ride_type_id', 'ryb_ride_waitng_time'], 'integer'],
            [['ryb_ride_waitng_charges'], 'number'],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_ride_waitng_id' => 'Waitng',
            'ryb_ride_type_id' => 'Ride Type',
            'ryb_ride_waitng_time' => 'Waiting time (minutes)',
            'ryb_ride_waitng_charges' => 'Waiting charges (Rs.)',
        ];
    }

    public function getRybRideType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

}
