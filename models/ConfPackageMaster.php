<?php

namespace app\models;

use Yii;

class ConfPackageMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%conf_package_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_conf_package_response_time', 'ryb_conf_package_no_of_driver'], 'default', 'value' => null],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_conf_package_response_time', 'ryb_conf_package_no_of_driver'], 'integer'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_conf_package_id' => 'Ryb Conf Package ID',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_conf_package_response_time' => 'Ryb Conf Package Response Time',
            'ryb_conf_package_no_of_driver' => 'Ryb Conf Package No Of Driver',
        ];
    }

    public function getBidTimeMasters() {
        return $this->hasMany(BidTimeMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getBidamntPercentMasters() {
        return $this->hasMany(BidamntPercentMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getCommPercentMasters() {
        return $this->hasMany(CommPercentMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getRybCity() {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybPincode() {
        return $this->hasOne(PincodeMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
    }

    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getDriverRadiusMasters() {
        return $this->hasMany(DriverRadiusMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getPenaltyAmntMasters() {
        return $this->hasMany(PenaltyAmntMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getRateCardMasters() {
        return $this->hasMany(RateCardMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

}
