<?php

namespace app\models;

use Yii;

class PromocodeCityMaster extends \yii\db\ActiveRecord {

    public $ryb_country_id;
    public $ryb_state_id;

    public static function tableName() {
        return '{{%promocode_city_master}}';
    }

    public function rules() {
        return [
            #[['ryb_promocode_id', 'ryb_city_id'], 'required'],
            [['ryb_promocode_id', 'ryb_city_id'], 'default', 'value' => null],
            [['ryb_promocode_id', 'ryb_city_id'], 'integer'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromocodeMaster::className(), 'targetAttribute' => ['ryb_promocode_id' => 'ryb_promocode_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_promocode_city_id' => 'Ryb Promocode City ID',
            'ryb_promocode_id' => 'Ryb Promocode ID',
            'ryb_country_id' => 'Country',
            'ryb_state_id' => 'State',
            'ryb_city_id' => 'City',
        ];
    }

    public function getRybCity() {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    public function getRybPromocode() {
        return $this->hasOne(PromocodeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

}
