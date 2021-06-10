<?php

namespace app\models;

use Yii;

class CityMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%city_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_title'], 'required'],
            [['ryb_city_title'], 'unique'],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_city_id' => 'Ryb City ID',
            'ryb_status_id' => 'Status ',
            'ryb_country_id' => 'Country',
            'ryb_state_id' => 'State',
            'ryb_city_title' => 'City Title',
            'ryb_city_added_at' => 'Added At',
        ];
    }

    public function getAdminMasters() {
        return $this->hasMany(AdminMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getPincodeMasters() {
        return $this->hasMany(PincodeMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

}
