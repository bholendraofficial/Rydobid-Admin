<?php

namespace app\models;

use Yii;

class RideStatusMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%ride_status_master}}';
    }

    public function rules() {
        return [
            [['ryb_ride_status_text'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_ride_status_id' => 'Ryb Ride Status ID',
            'ryb_ride_status_text' => 'Ryb Ride Status Text',
        ];
    }

    public function getUserRideMasters() {
        return $this->hasMany(UserRideMaster::className(), ['ryb_ride_status_id' => 'ryb_ride_status_id']);
    }

}
