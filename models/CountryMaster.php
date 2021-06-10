<?php

namespace app\models;

use Yii;

class CountryMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%country_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_title'], 'required'],
            [['ryb_country_added_at'], 'safe'],
            [['ryb_country_title'], 'string', 'max' => 256],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_country_id' => 'Country ID',
            'ryb_status_id' => 'Status',
            'ryb_country_title' => 'Country Title',
            'ryb_country_added_at' => 'Added At',
        ];
    }

    public function getAdminMasters() {
        return $this->hasMany(AdminMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getCityMasters() {
        return $this->hasMany(CityMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getPincodeMasters() {
        return $this->hasMany(PincodeMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    public function getStateMasters() {
        return $this->hasMany(StateMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

}
