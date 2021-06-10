<?php

namespace app\models;

use Yii;

class PromocodeCabTypeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%promocode_cab_type_master}}';
    }

    public function rules() {
        return [
            #[['ryb_promocode_id', 'ryb_cabtype_id'], 'required'],
            [['ryb_promocode_id', 'ryb_cabtype_id'], 'default', 'value' => null],
            [['ryb_promocode_id', 'ryb_cabtype_id'], 'integer'],
            [['ryb_cabtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => CabtypeMaster::className(), 'targetAttribute' => ['ryb_cabtype_id' => 'ryb_cabtype_id']],
            [['ryb_promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PromocodeMaster::className(), 'targetAttribute' => ['ryb_promocode_id' => 'ryb_promocode_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_promocode_cab_type_id' => 'Ryb Promocode Cab Type ID',
            'ryb_promocode_id' => 'Ryb Promocode ID',
            'ryb_cabtype_id' => 'Cab Type',
        ];
    }

    public function getRybCabtype() {
        return $this->hasOne(CabtypeMaster::className(), ['ryb_cabtype_id' => 'ryb_cabtype_id']);
    }

    public function getRybPromocode() {
        return $this->hasOne(PromocodeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

}
