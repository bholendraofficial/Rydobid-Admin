<?php

namespace app\models;

use Yii;

class NightChargeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%night_charge_master}}';
    }

    public function rules() {
        return [
            [['ryb_ride_type_id'], 'default', 'value' => null],
            [['ryb_ride_type_id'], 'integer'],
            [['ryb_night_charge'], 'number'],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_night_charge_id' => 'Ryb Night Charge ID',
            'ryb_ride_type_id' => 'Waitng Type ID',
            'ryb_night_charge' => 'Night Charge',
        ];
    }

    public function getRybConfWaitngType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

}
