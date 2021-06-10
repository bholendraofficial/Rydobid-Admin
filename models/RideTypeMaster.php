<?php

namespace app\models;

use Yii;

class RideTypeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%ride_type_master}}';
    }

    public function rules() {
        return [
            [['ryb_ride_type_title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_ride_type_id' => 'Ride Type',
            'ryb_ride_type_title' => 'Ride Type Title',
        ];
    }

    public function getConfWaitngMasters() {
        return $this->hasMany(ConfWaitngMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

    public function getNightChargeMasters() {
        return $this->hasMany(NightChargeMaster::className(), ['ryb_conf_waitng_type_id' => 'ryb_ride_type_id']);
    }

}
