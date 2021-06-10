<?php

namespace app\models;

use Yii;

class RentalPackageMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%rental_package_master}}';
    }

    public function rules() {
        return [
            [['ryb_cabtype_id', 'ryb_rental_package_hour', 'ryb_rental_package_km_allowed'], 'default', 'value' => null],
            [['ryb_cabtype_id', 'ryb_rental_package_hour', 'ryb_rental_package_km_allowed'], 'integer'],
            [['ryb_rental_package_km_ext_charge', 'ryb_rental_package_hr_ext_charge'], 'number'],
            [['ryb_cabtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => CabtypeMaster::className(), 'targetAttribute' => ['ryb_cabtype_id' => 'ryb_cabtype_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_rental_package_id' => 'Rental Package',
            'ryb_cabtype_id' => 'Cab Type',
            'ryb_rental_package_hour' => 'Hour Package',
            'ryb_rental_package_km_allowed' => 'KM Allowed',
            'ryb_rental_package_km_ext_charge' => 'Extra KM Charge',
            'ryb_rental_package_hr_ext_charge' => 'Extra Hour Charge',
        ];
    }

    public function getRybCabtype() {
        return $this->hasOne(CabtypeMaster::className(), ['ryb_cabtype_id' => 'ryb_cabtype_id']);
    }

}
