<?php

namespace app\models;

use Yii;

class AirportMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%airport_master}}';
    }

    public function rules() {
        return [
            [['ryb_airport_name', 'ryb_airport_latitude', 'ryb_airport_longitude'], 'required'],
            [['ryb_airport_latitude', 'ryb_airport_longitude'], 'number'],
            [['ryb_airport_name'], 'string', 'max' => 255],
            [['ryb_airport_added_at'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_airport_id' => 'Airport ID',
            'ryb_airport_name' => 'Airport-Name',
            'ryb_airport_latitude' => 'Airport-Latitude',
            'ryb_airport_longitude' => 'Airport-Longitude',
            'ryb_airport_added_at' => 'Added At',
        ];
    }

    public function getAirportCityMasters() {
        return $this->hasMany(AirportCityMaster::className(), ['ryb_airport_id' => 'ryb_airport_id']);
    }

}
