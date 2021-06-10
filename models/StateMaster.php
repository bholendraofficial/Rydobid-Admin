<?php

namespace app\models;

use Yii;

class StateMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%state_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_title'], 'required'],
            [['ryb_state_title'], 'unique'],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_state_id' => 'State ID',
            'ryb_status_id' => 'Status',
            'ryb_country_id' => 'Country',
            'ryb_state_title' => 'State Title',
            'ryb_state_added_at' => 'Added At',
        ];
    }

    public function getAdminMasters() {
        return $this->hasMany(AdminMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getCityMasters() {
        return $this->hasMany(CityMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getPincodeMasters() {
        return $this->hasMany(PincodeMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

}
