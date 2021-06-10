<?php

namespace app\models;

use Yii;

class DriverCabStatusMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%driver_cab_status_master}}';
    }

    public function rules() {
        return [
            [['ryb_driver_cab_status_text'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_driver_cab_status_id' => 'Cab Status ID',
            'ryb_driver_cab_status_text' => 'Cab Status',
        ];
    }

    public function getDriverCabMasters() {
        return $this->hasMany(DriverCabMaster::className(), ['ryb_driver_cab_status_id' => 'ryb_driver_cab_status_id']);
    }

}
