<?php

namespace app\models;

use Yii;

class PromocodeRideTypeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%promocode_ride_type_master}}';
    }

    public function rules() {
        return [
            #[['ryb_ride_type_id', 'ryb_promocode_id'], 'required'],
            [['ryb_ride_type_id', 'ryb_promocode_id'], 'default', 'value' => null],
            [['ryb_ride_type_id', 'ryb_promocode_id'], 'integer'],
            [['ryb_promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromocodeMaster::className(), 'targetAttribute' => ['ryb_promocode_id' => 'ryb_promocode_id']],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_promocode_ride_type_id' => 'Ryb Promocode Ride Type ID',
            'ryb_ride_type_id' => 'Ride Type',
            'ryb_promocode_id' => 'Ryb Promocode ID',
        ];
    }

    public function getRybPromocode() {
        return $this->hasOne(PromocodeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

    public function getRybRideType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

}
