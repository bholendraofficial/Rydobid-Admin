<?php

namespace app\models;

use Yii;

class AirportCityMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%airport_city_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_airport_id'], 'default', 'value' => null],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_airport_id'], 'required'],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_airport_id'], 'integer'],
            [['ryb_airport_id'], 'exist', 'skipOnError' => true, 'targetClass' => AirportMaster::className(), 'targetAttribute' => ['ryb_airport_id' => 'ryb_airport_id']],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_airport_city_id' => 'Airport City ID',
            'ryb_country_id' => 'Country',
            'ryb_state_id' => 'State',
            'ryb_city_id' => 'City',
            'ryb_airport_id' => 'Airport',
        ];
    }

    public function getRybAirport() {
        return $this->hasOne(AirportMaster::className(), ['ryb_airport_id' => 'ryb_airport_id']);
    }

    public function getRybCity() {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

}
