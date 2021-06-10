<?php

namespace app\models;

use Yii;

class PincodeMaster extends \yii\db\ActiveRecord {

    public $ryb_csv_file;

    public static function tableName() {
        return '{{%pincode_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_title', 'ryb_pincode_number'], 'required'],
            [['ryb_pincode_number'], 'unique'],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_title', 'ryb_pincode_number', 'ryb_csv_file'], 'required', 'on' => 'import'],
            [['ryb_pincode_number'], 'unique', 'on' => 'import'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_pincode_id' => 'Pincode',
            'ryb_status_id' => 'Status',
            'ryb_country_id' => 'Country',
            'ryb_state_id' => 'State',
            'ryb_city_id' => 'City',
            'ryb_pincode_title' => 'Area title',
            'ryb_pincode_number' => 'Pin code',
            'ryb_pincode_added_at' => 'Added At',
            'ryb_csv_file' => 'Pincode File(CSV)',
        ];
    }

    public function getAdminMasters() {
        return $this->hasMany(AdminMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
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

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

}
