<?php

namespace app\models;

use Yii;

class RateCardMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%rate_card_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id', 'ryb_conf_package_id', 'ryb_time_slot_id'], 'default', 'value' => null],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id', 'ryb_conf_package_id', 'ryb_time_slot_id'], 'integer'],
            [['ryb_rate_card_pr_km'], 'number'],
            [['ryb_cabtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => CabtypeMaster::className(), 'targetAttribute' => ['ryb_cabtype_id' => 'ryb_cabtype_id']],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_conf_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfPackageMaster::className(), 'targetAttribute' => ['ryb_conf_package_id' => 'ryb_conf_package_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
            [['ryb_time_slot_id'], 'exist', 'skipOnError' => true, 'targetClass' => TimeSlotMaster::className(), 'targetAttribute' => ['ryb_time_slot_id' => 'ryb_time_slot_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_rate_card_id' => 'Ryb Rate Card ID',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_ride_type_id' => 'Ryb Ride Type ID',
            'ryb_cabtype_id' => 'Ryb Cabtype ID',
            'ryb_conf_package_id' => 'Ryb Conf Package ID',
            'ryb_time_slot_id' => 'Ryb Time Slot ID',
            'ryb_rate_card_pr_km' => 'Ryb Rate Card Pr Km',
        ];
    }

    public function getRybCabtype() {
        return $this->hasOne(CabtypeMaster::className(), ['ryb_cabtype_id' => 'ryb_cabtype_id']);
    }

    public function getRybCity() {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    public function getRybConfPackage() {
        return $this->hasOne(ConfPackageMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybPincode() {
        return $this->hasOne(PincodeMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
    }

    public function getRybRideType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getRybTimeSlot() {
        return $this->hasOne(TimeSlotMaster::className(), ['ryb_time_slot_id' => 'ryb_time_slot_id']);
    }

}
