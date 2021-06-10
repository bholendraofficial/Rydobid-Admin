<?php

namespace app\models;

use Yii;

class StatusMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%status_master}}';
    }

    public function rules() {
        return [
            [['ryb_status_id'], 'required'],
            [['ryb_status_id'], 'default', 'value' => null],
            [['ryb_status_id'], 'integer'],
            [['ryb_status_text'], 'string', 'max' => 256],
            [['ryb_status_id'], 'unique'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_status_id' => 'Ryb Status ID',
            'ryb_status_text' => 'Status',
        ];
    }

    public function getAdminMasters() {
        return $this->hasMany(AdminMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getCabtypeMasters() {
        return $this->hasMany(CabtypeMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getCityMasters() {
        return $this->hasMany(CityMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getCountryMasters() {
        return $this->hasMany(CountryMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getPincodeMasters() {
        return $this->hasMany(PincodeMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getRoleMasters() {
        return $this->hasMany(RoleMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getStateMasters() {
        return $this->hasMany(StateMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

}
